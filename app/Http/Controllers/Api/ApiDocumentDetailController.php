<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ConexionSAP;

class ApiDocumentDetailController extends Controller
{

    private function getConsulta(int $docEntry, string $typeDocument)
    {

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');
        $typeDocumentDetail = $typeDocument == 'Pedido' ? 'RDR1' : 'WTQ1';

        $query = "Select T1.\"ItemCode\", T1.\"ItemName\", T0.\"Quantity\"
        from $sociedad.$typeDocumentDetail T0
        inner join $sociedad.OITM T1 on T0.\"ItemCode\" = T1.\"ItemCode\"
        where T0.\"DocEntry\" = $docEntry";

        return DB::connection('sap-hana-odbc')->select($query);
    }

    private function getValidateProduct(int $docEntry, string $itemCode, string $typeDocument)
    {

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');
        $typeDocumentDetail = $typeDocument == 'Pedido' ? 'RDR1' : 'WTQ1';

        $query = "SELECT COUNT(\"LineNum\") as \"Line\" FROM $sociedad.$typeDocumentDetail WHERE \"DocEntry\" = $docEntry AND \"ItemCode\" = '$itemCode'";
        // return $query;
        return DB::connection('sap-hana-odbc')->select($query);
    }

    public function getDetailDocument(Request $request)
    {

        $request->validate([
            'docEntry' => 'required|integer',
            'typeDocument' => 'required|string',
        ]);

        $documentDetail = $this->getConsulta($request->docEntry, $request->typeDocument);

        return response()->json([
            'data' => $documentDetail
        ], 200);
    }

    public function validateProduct(Request $request)
    {

        $request->validate([
            'docEntry' => 'required|integer',
            'itemCode' => 'required|string',
            'typeDocument' => 'required|string',
        ]);

        $validateProduct = $this->getValidateProduct($request->docEntry, $request->itemCode, $request->typeDocument);

        // return $validateProduct;
        return response()->json(
            $validateProduct[0]->Line == 0 ? false : true,
            200
        );
    }

    private function obtenerInformacionEncabezado(int $docEntry, string $typeDocument)
    {

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');
        $detailTable = $typeDocument == 'ORDR' ? 'RDR1' : 'WTQ1';

        $query = "SELECT T0.\"CardCode\", T0.\"CardName\", TO_DATE(T0.\"DocDate\") as \"DocDate\", T1.\"WhsCode\" from $sociedad.$typeDocument T0 INNER JOIN $sociedad.$detailTable T1 ON T1.\"DocEntry\" = T0.\"DocEntry\" WHERE T0.\"DocEntry\" = $docEntry";

        return DB::connection('sap-hana-odbc')->select($query);
    }

    private function obtenerBaseLinea(string $itemCode, string $typeDocument, int $docEntry){

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');
        $typeDocument = $typeDocument == 'ORDR' ? 'RDR1' : 'WTQ1';
        $query = "select \"LineNum\" from $sociedad.$typeDocument where \"DocEntry\" = $docEntry and \"ItemCode\" = '$itemCode'";

        return DB::connection('sap-hana-odbc')->select($query);
    }

    public function insertDetailDocuemts(Request $request)
    {

        $conexionSAP = new ConexionSAP();
        $conexionSAP->validarLogin();

        $json = $request->json()->all();

        $documentos = array();

        foreach ($json as $value) {
            $documentos[] = [
                'DocEntry' => $value['DocEntry'],
                'DocNum' => $value['DocNum'],
                'Type' => $value['Type'],
                'ItemCode' => $value['ItemCode'],
                'Quantity' => $value['Quantity'],
                'Lote' => $value['Lote'],
            ];
        }
        $typeDocument = $documentos[0]['Type'] == 'Pedido' ? 'ORDR' : 'OWTQ';

        $encabezado = $this->obtenerInformacionEncabezado($documentos[0]['DocEntry'], $typeDocument);

        if (count($encabezado) == 0) {
            return response()->json([
                'message' => 'No se encontro el encabezado del documento'
            ], 404);
        } else {

            $encabezado = $encabezado[0];
            $detalles = '';

            foreach ($documentos as $detalleL) {
                $cc = $this->obtenerBaseLinea($detalleL['ItemCode'], $typeDocument, $detalleL['DocEntry']);
                $cc = $cc[0];
                $detalles .= "{
                    \"ItemCode\": \"$detalleL[ItemCode]\",
                    \"Quantity\": $detalleL[Quantity],
                    \"WarehouseCode\": \"".$encabezado->WhsCode."\",
                    \"BaseEntry\": ".$detalleL['DocEntry'].",
                    \"BaseLine\": ".$cc->LineNum.",
                    \"BaseType\": 17,
                    \"TaxCode\": \"IVA\",
                    \"BatchNumbers\": [
                        {
                            \"BatchNumber\": \"$detalleL[Lote]\",
                            \"Quantity\": $detalleL[Quantity]
                        }
                    ]
                },";
            }

            $detalles = substr($detalles, 0, -1);
            $jsonSAP = "{
                        \"CardCode\": \"$encabezado->CardCode\",
                        \"DocDate\": \"$encabezado->DocDate\",
                        \"DocDueDate\": \"$encabezado->DocDate\",
                        \"DocType\": \"dDocument_Items\",
                        \"DocumentLines\": [
                            $detalles
                        ]
                    }";

            // return $jsonSAP;

            $datos = $conexionSAP->insertSAP($jsonSAP, $typeDocument);

            $jsonSAP = json_decode($datos);

            if ($jsonSAP == null) {
                return response()->json([
                    'message' => utf8_encode('Error al momento de insertar a SAP')
                ], 404);
            }
            else{
                return response()->json([
                    'message' => 'Se inserto correctamente',
                    'docEntry' => $jsonSAP->DocEntry,
                    'docNum' => $jsonSAP->DocNum,
                ], 200);
            }
        }
    }
}

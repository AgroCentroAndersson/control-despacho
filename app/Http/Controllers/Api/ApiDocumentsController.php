<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDocumentsController extends Controller
{


    private function getConsulta(int $store, int $grocer, string $typeDoc, string $searchTerm){

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');

        $busqueda = '';

        if ($searchTerm != 'vacio') {
            $busqueda = " and T2.\"CardCode\" like '%$searchTerm%' or
            T2.\"CardName\" like '%$searchTerm%' or
            T0.\"DocNum\" like '%$searchTerm%' ";
        }

        if($typeDoc == 'orders'){
            $query = "Select T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", TRIM(T2.\"CardName\") as \"CardName\", TO_DATE(T0.\"DocDueDate\") as \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\", 'Pedido' as \"Type\"
            from $sociedad.ORDR T0
            inner join $sociedad.RDR1 T1 on T0.\"DocEntry\" = T1.\"DocEntry\"
            inner join $sociedad.OCRD T2 on T0.\"CardCode\" = T2.\"CardCode\"
            where 	T1.\"WhsCode\" = '$store' and
                    T0.\"DocStatus\" = 'O' and
                    T0.\"CANCELED\" = 'N' and
                    T1.\"ItemCode\" like '%GT' and
                    T1.\"OpenQty\" > 0
                    $busqueda
            group by T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\"
            order by \"DocDueDate\" asc
            ";
        }
        else if($typeDoc == 'transfers'){
            $query ="Select T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", TO_DATE(T0.\"DocDueDate\") as \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\", 'Transferencia' as \"Type\"
            from $sociedad.OWTQ T0
            inner join $sociedad.WTQ1 T1 on T0.\"DocEntry\" = T1.\"DocEntry\"
            inner join $sociedad.OCRD T2 on T0.\"CardCode\" = T2.\"CardCode\"
            where 	T1.\"WhsCode\" = '$store' and
                    T0.\"DocStatus\" = 'O' and
                    T0.\"CANCELED\" = 'N' and
                    T1.\"ItemCode\" like '%GT' and
                    T1.\"OpenQty\" > 0
                    $busqueda
            group by T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\"
            order by \"DocDueDate\" asc";
            }

        // return $query;

        return DB::connection('sap-hana-odbc')->select($query);

    }

    public function listDocuments(Request $request){

        $request->validate([
            'store' => 'required|integer',
            'grocer' => 'required|integer',
            'typeDoc' => 'required|string',
            'searchTerm' => 'required|string'
        ]);

        // $datos = $request->searchTerm != 'vacio' ? '' : $request->searchTerm;

        $documents = $this->getConsulta($request->store, $request->grocer, $request->typeDoc, $request->searchTerm);

        // return $documents;

        foreach ($documents as $document){
            $document->CardName = utf8_encode($document->CardName);
        }

        if (count($documents) == 0) {
            return response()->json([
                'data' => 'No hay documentos'
            ], 200);
        }else{
            return response()->json([
                'data' => $documents
            ], 200);
        }



    }

}

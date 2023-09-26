<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiBatchController extends Controller
{
    private function getConsulta(string $itemCode, string $batchNumber, int $store){

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');

        $query = "select t0.\"Quantity\"
        from $sociedad.OBTQ t0
            inner join $sociedad.OBTN t1 on t0.\"SysNumber\" = t1.\"SysNumber\" and t0.\"ItemCode\" = t1.\"ItemCode\"
        where t0.\"WhsCode\" = '$store'
            and t1.\"DistNumber\" = '$batchNumber'
            and t0.\"ItemCode\" = '$itemCode'";
        // return $query;
        return DB::connection('sap-hana-odbc')->select($query);

    }

    private function validarFechaVencimiento(string $itemCode, int $store){

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');

        $query = "select t1.\"DistNumber\"
        from $sociedad.OBTQ t0
        inner join $sociedad.OBTN t1 on t0.\"SysNumber\" = t1.\"SysNumber\" and t0.\"ItemCode\" = t1.\"ItemCode\"
        where t0.\"WhsCode\" = '$store'
        and t0.\"ItemCode\" = '$itemCode'
        and t0.\"Quantity\" > 0
        order by t1.\"ExpDate\" asc
        limit 1";
        return DB::connection('sap-hana-odbc')->select($query);

    }

    public function fechaVencimiento(Request $request){

        $request->validate([
            'itemCode' => 'required|string',
            'batchNumber' => 'required|string',
            'store' => 'required|string',
        ]);

        $quantityBatch = $this->validarFechaVencimiento($request->itemCode, $request->store);
        if ($quantityBatch{0}->DistNumber != $request->batchNumber) {
            return response()->json([
                'response' => false,
                'response' => ', el lote no es el mas antiguo.'
            ], 200);
        }
        else {
            return response()->json([
                'response' => true,
                'response' => ''
            ], 200);
        }

    }

    public function getQuantityBatch(Request $request){

        $request->validate([
            'itemCode' => 'required|string',
            'batchNumber' => 'required|string',
            'quantity' => 'required|string',
            'store' => 'required|string',
        ]);

        $quantityBatch = $this->getConsulta($request->itemCode, $request->batchNumber, $request->store);
        // return $quantityBatch;
        if(count($quantityBatch) == 0){
            return response()->json([
                'response' => false,
                'msg' => 'Información ingresada no valida'
            ], 200);
        }
        else {
            $respon = $quantityBatch[0]->Quantity >= $request->quantity ? true : false;

            return response()->json([
                'response' => $respon,
                'msg' => $respon ? 'Cantidad disponible' : 'Cantidad no disponible'
            ], 200);
        }

    }
}

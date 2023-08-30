<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiDocumentsController extends Controller
{


    private function getConsulta(int $store, int $grocer){

        $sociedad = env('DB_DATABASE_SAP', 'GT_AGROCENTRO_2016');

        $query = "Select T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", TO_DATE(T0.\"DocDueDate\") as \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\", 'Pedido' as \"Type\"
        from $sociedad.ORDR T0
        inner join $sociedad.RDR1 T1 on T0.\"DocEntry\" = T1.\"DocEntry\"
        inner join $sociedad.OCRD T2 on T0.\"CardCode\" = T2.\"CardCode\"
        where 	T1.\"WhsCode\" = '$store' and
                T1.\"SlpCode\" = '$grocer' and
                T0.\"DocStatus\" = 'O' and
                T0.\"CANCELED\" = 'N'
        group by T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\"
        union
        Select T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", TO_DATE(T0.\"DocDueDate\") as \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\", 'Transferencia' as \"Type\"
        from $sociedad.OWTQ T0
        inner join $sociedad.WTQ1 T1 on T0.\"DocEntry\" = T1.\"DocEntry\"
        inner join $sociedad.OCRD T2 on T0.\"CardCode\" = T2.\"CardCode\"
        where 	T1.\"WhsCode\" = '$store' and
                T1.\"SlpCode\" = '$grocer' and
                T0.\"DocStatus\" = 'O' and
                T0.\"CANCELED\" = 'N'
        group by T0.\"DocEntry\", T0.\"DocNum\", T2.\"CardCode\", T2.\"CardName\", \"DocDueDate\", T0.\"DocTotal\", T0.\"SlpCode\", T1.\"WhsCode\"
        order by \"DocDueDate\" desc";

        return DB::connection('sap-hana-odbc')->select($query);

    }

    public function listDocuments(Request $request){

        $request->validate([
            'store' => 'required|integer',
            'grocer' => 'required|integer',
        ]);

        $documents = $this->getConsulta($request->store, $request->grocer);

        return response()->json([
            'data' => $documents
        ], 200);

    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Grocer;
use Illuminate\Http\Request;

class ApiGrocerController extends Controller
{
    public function store(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:grocers',
            'email' => 'string|max:255',
            'phone' => 'required|string|max:8',
            'store_id' => 'required|integer',
            'password' => 'required|string|min:8',
        ]);


        $grocer = Grocer::create($request->all());

        return response($grocer, 200);

    }

    public function loginResp(Request $request){

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $grocer = Grocer::where('username', '=', $request->username)->where('state', 1)->first();

        // dd($grocer);

        if (isset($grocer->id)) {

            // dd($grocer->password, $request->password, password_verify($request->password, $grocer->password));

           if(password_verify($request->password, $grocer->password)){
                return response()->json([
                    'response' => true,
                    'grocer' => $grocer->SlpCode,
                    'store' => $grocer->store->codeSAP,
                    'id' => $grocer->id,
                    'name' => $grocer->name,
                ], 200);
           }
           else {
                return response()->json([
                    'response' => false,
                    'msg' => 'Password incorrecta'
                ], 200);
           }

        }
        else {
            return response()->json([
                'response' => false,
                'msg' => 'Usuario no encontrado'
            ], 200);
        }

    }
}

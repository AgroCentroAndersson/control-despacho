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
}

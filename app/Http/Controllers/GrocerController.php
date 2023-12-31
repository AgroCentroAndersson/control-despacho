<?php

namespace App\Http\Controllers;

use App\Mail\GrocerMailable;
use App\Models\Country;
use App\Models\Grocer;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class GrocerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('grocer.index');
    }

    public function validateLogin(Request $request){

        $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $grocer = Grocer::where('username', '=', $request->username)->first();

        $encryptPassword = Hash::make($request->password);

        if($grocer){
            if($grocer->password == $encryptPassword){
                return response()->json([
                    'response' => true,
                    'msg' => 'Bienvenido',
                    'data' => $grocer
                ], 200);
            }
            else {
                return response()->json([
                    'response' => false,
                    'msg' => 'Contraseña incorrecta'
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('state', '=', 1)->get();
        $countries = Country::all();
        return view('grocer.create', compact('stores', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:grocers',
            'email' => 'string|max:255',
            'phone' => 'required|string|max:8',
            'store_id' => 'required|integer|exists:stores,id',
            'country_id' => 'required|integer|exists:countries,id',
            'SlpCode' => 'required|string|max:255',
        ]);

        $password = Str::random(8);


        $grocer = Grocer::create([
            'name' => $request->name,
            'username' => Str::upper($request->username),
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'store_id' => $request->store_id,
            'country_id' => $request->country_id,
            'SlpCode' => $request->SlpCode,
        ]);

        Mail::to($request->email)->send(new GrocerMailable($grocer, $password));
        return view('grocer.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

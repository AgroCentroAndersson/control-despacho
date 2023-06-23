<?php

namespace App\Http\Controllers;

use App\Mail\GrocerMailable;
use App\Models\Grocer;
use App\Models\Store;
use Illuminate\Http\Request;
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stores = Store::where('state', '=', 1)->get();
        return view('grocer.create', compact('stores'));
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
            'store_id' => 'required|integer',
        ]);

        $password = Str::random(8);


        $grocer = Grocer::create([
            'name' => $request->name,
            'username' => Str::upper($request->username),
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $password,
            'store_id' => $request->store_id,
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

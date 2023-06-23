<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('store.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('store.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
            ]
        );

        $store = Store::create($request->all());

        // session()->flash('success', 'Store created successfully!');

        return view('store.index');

        // return $request;
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $store = Store::find($id);

        return view('store.show', compact('store'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $store = Store::find($id);

        return view('store.edit', compact('store'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate(
            [
                'name' => 'required',
                'address' => 'required',
                'phone' => 'required',
            ]
        );

        $store = Store::find($id);

        $store->update($request->all());

        // session()->flash('success', 'Store updated successfully!');

        return view('store.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $store = Store::find($id);

        $store->delete();

        // session()->flash('success', 'Store deleted successfully!');

        return view('store.index');
    }
}

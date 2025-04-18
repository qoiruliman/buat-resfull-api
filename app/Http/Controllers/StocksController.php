<?php

namespace App\Http\Controllers;

use App\Models\Stocks;
use Illuminate\Http\Request;
use Validator;

class StocksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $stocks = Stocks::all();

        return response()->json([
            $stocks
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'harga_beli' => 'required|numeric|max:255',
            'harga_jual' => 'required|numeric|max:255',
            'stok' => 'required|integer',
            'kategori' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed '], 422);
        }

        $stock = Stocks::create([
            'nama_stock' => $request->nama_stock,
            'detail' => $request->detail,
        ]);

        return response()->json(['Message' => ' create success']);

    }

    /**
     * Display the specified resource.
     */
    public function show(Stocks $stocks)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $Stocks = Stocks::find($stocks);

        return response()->json([
            $Stocks
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Stocks $stocks)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required|string',
            'harga_beli' => 'required|numeric|max:255',
            'harga_jual' => 'required|numeric|max:255',
            'stok' => 'required|integer',
            'kategori' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed '], 422);
        }

        $Stocks = Stocks::find($stocks);

        if (!$Stocks) {
            return response()->json(['Message' => 'Data cannot be updated'], 400);
        }

        $Stocks->update($request->all());
        return response()->json(['Message' => 'update success ']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Stocks $stocks)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $stocks = Stocks::find($stocks);

        if (!$stocks) {
            return response()->json(['Message' => 'Data cannot be deleted'], 400);
        }

        return response()->json([
            'Message' => 'delete success'
        ], 200);

    }
}

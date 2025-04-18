<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use Illuminate\Http\Request;
use Validator;

class InvoicesController extends Controller
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

        $Invoices = Invoices::all();

        return response()->json([
            $Invoices
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
            'id_produk' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed'], 422);
        }

        // Hitung total otomatis
        $total = $request->qty * $request->harga_jual;

        // Hitung kembalian otomatis
        $kembalian = $request->dibayar - $total;

        if ($kembalian < 0) {
            return response()->json(['Message' => 'Uang dibayar kurang dari total'], 400);
        }

        $invoice = Invoices::create([
            'id_produk' => $request->id_produk,
            'qty' => $request->qty,
            'harga_jual' => $request->harga_jual,
            'total' => $total,
            'dibayar' => $request->dibayar,
            'dikembalikan' => $kembalian,
            'user_id' => $user->id,
        ]);

        return response()->json([
            'Message' => 'Create success',
            'data' => $invoice
        ], 201);
    }


    /**
     * Display the specified resource.
     */
    public function show(Invoices $Invoices)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $Invoices = Invoices::find($Invoices);

        return response()->json([
            $Invoices
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoices $invoice)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $validator = Validator::make($request->all(), [
            'id_produk' => 'required|string',
            'qty' => 'required|integer|min:1',
            'harga_jual' => 'required|numeric|min:0',
            'dibayar' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed'], 422);
        }

        // Hitung total dan kembalian ulang
        $total = $request->qty * $request->harga_jual;
        $kembalian = $request->dibayar - $total;

        $invoice->update([
            'id_produk' => $request->id_produk,
            'qty' => $request->qty,
            'harga_jual' => $request->harga_jual,
            'total' => $total,
            'dibayar' => $request->dibayar,
            'dikembalikan' => $kembalian,
        ]);

        return response()->json([
            'Message' => 'Update success',
            'data' => $invoice
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoices $Invoices)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $Invoices = Invoices::find($Invoices);

        if (!$Invoices) {
            return response()->json(['Message' => 'Data cannot be deleted'], 400);
        }

        return response()->json([
            'Message' => 'delete success'
        ], 200);

    }
}

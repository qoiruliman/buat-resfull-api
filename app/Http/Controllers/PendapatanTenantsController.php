<?php

namespace App\Http\Controllers;

use App\Models\PendapatanTenants;
use Illuminate\Http\Request;
use Validator;

class PendapatanTenantsController extends Controller
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

        $PendapatanTenants = PendapatanTenants::all();

        return response()->json([
            $PendapatanTenants
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
            'total_pendapatan' => 'required|numeric',
            'setoran_tenant' => 'required|numeric|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed '], 422);
        }

        $stock = PendapatanTenants::create([
            'total_pendapatan' => $request->total_pendapatan,
            'setoran_tenant' => $request->setoran_tenant,
        ]);

        return response()->json(['Message' => ' create success']);

    }

    /**
     * Display the specified resource.
     */
    public function show(PendapatanTenants $PendapatanTenants)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $PendapatanTenants = PendapatanTenants::find($PendapatanTenants);

        return response()->json([
            $PendapatanTenants
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PendapatanTenants $PendapatanTenants)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $validator = Validator::make($request->all(), [
            'total_pendapatan' => 'required|numeric',
            'setoran_tenant' => 'required|numeric|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed '], 422);
        }


        $PendapatanTenants = PendapatanTenants::find($PendapatanTenants);

        if (!$PendapatanTenants) {
            return response()->json(['Message' => 'Data cannot be updated'], 400);
        }

        $PendapatanTenants->update($request->all());
        return response()->json(['Message' => 'update success ']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PendapatanTenants $PendapatanTenants)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $PendapatanTenants = PendapatanTenants::find($PendapatanTenants);

        if (!$PendapatanTenants) {
            return response()->json(['Message' => 'Data cannot be deleted'], 400);
        }

        return response()->json([
            'Message' => 'delete success'
        ], 200);

    }
}

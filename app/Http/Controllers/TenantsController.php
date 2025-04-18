<?php

namespace App\Http\Controllers;

use App\Models\Tenants;
use Illuminate\Http\Request;
use Validator;

class TenantsController extends Controller
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

        $tenants = Tenants::all();

        return response()->json([
            $tenants
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
            'nama_tenant' => 'required|string',
            'detail' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed '], 422);
        }

        $tenant = Tenants::create([
            'nama_tenant' => $request->nama_tenant,
            'detail' => $request->detail,
        ]);

        return response()->json([
            'Message' => ' create success'
        ]);

    }

    /**
     * Display the specified resource.
     */
    public function show(tenants $tenant)
    {
        $user = auth()->user();

        if (!$user) {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $tenants = Tenants::find($tenant);

        return response()->json([
            $tenants
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, tenants $tenant)
    {

        $user = auth()->user();


        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $validator = Validator::make($request->all(), [
            'nama_tenant' => 'required|string',
            'detail' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json(['Message' => 'Data cannot be processed '], 422);
        }

        $tenants = Tenants::find($tenant);

        if (!$tenants) {
            return response()->json(['Message' => 'Data cannot be updated'], 400);
        }

        $tenant->update([
            'nama_tenant' => $request->nama_tenant,
            'detail' => $request->detail
        ]);


        return response()->json(['Message' => 'update success ']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(tenants $tenant)
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json(['Message' => 'Unauthorized user'], 401);
        }

        $tenants = Tenants::find($tenant);

        if (!$tenants) {
            return response()->json(['Message' => 'Data cannot be deleted'], 400);
        }

        return response()->json([
            'Message' => 'delete success'
        ], 200);

    }
}

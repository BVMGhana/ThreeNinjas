<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\BlackNinja;
use Illuminate\Http\Request;

class BlackNinjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $black_ninjas = BlackNinja::with(['league', 'tip'])->get();
            return response()->json($black_ninjas);

        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $black_ninja = new BlackNinja([
                'league_id' => $request->league_id,
                'fixtures' => $request->fixtures,
                'tip_id' => $request->tip_id,
                'results' => $request->results,
            ]);
            $black_ninja->save();
            return response()->json(['success' => true, 'message' => 'Record added.'], 201);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $black_ninja =  BlackNinja::with(['league', 'tip'])->findOrFail($id);
            return response()->json($black_ninja);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlackNinja $blackNinja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $black_ninja = BlackNinja::findOrFail($id);
            $black_ninja->league_id = $request->league_id;
            $black_ninja->fixtures = $request->fixtures;
            $black_ninja->tip_id = $request->tip_id;
            $black_ninja->results = $request->results;
            $black_ninja->save();

            return response()->json(['success' => true, 'message' => 'Record updated.'], 201);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $black_ninja = BlackNinja::findOrFail($id);
            $black_ninja->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted.'], 200);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\WhiteNinja;
use Illuminate\Http\Request;

class WhiteNinjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $white_ninjas = WhiteNinja::with(['league', 'tip'])->get();
            return response()->json($white_ninjas);

        } catch (\Exception $e) {
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
        $request->validate([
            'league_id' => 'required|numeric',
            'fixtures' => 'required|string|max:255',
            'tip_id' => 'required|numeric',
            'results' => 'required|boolean'
        ]);

        try {

            $white_ninja = new WhiteNinja([
                'league_id' => $request->league_id,
                'fixtures' => $request->fixtures,
                'tip_id' => $request->tip_id,
                'results' => $request->results,
            ]);
            $white_ninja->save();
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
            $white_ninja =  WhiteNinja::with(['league', 'tip'])->findOrFail($id);
            return response()->json($white_ninja);

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
    public function edit(WhiteNinja $whiteNinja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'league_id' => 'required|numeric',
            'fixtures' => 'required|string|max:255',
            'tip_id' => 'required|numeric',
            'results' => 'required|boolean'
        ]);
        
        try {
            $white_ninja = WhiteNinja::findOrFail($id);
            $white_ninja->league_id = $request->league_id;
            $white_ninja->fixtures = $request->fixtures;
            $white_ninja->tip_id = $request->tip_id;
            $white_ninja->results = $request->results;
            $white_ninja->save();

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
            $white_ninja = WhiteNinja::findOrFail($id);
            $white_ninja->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted.'], 200);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

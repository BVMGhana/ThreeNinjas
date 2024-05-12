<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\RedNinja;
use Illuminate\Http\Request;

class RedNinjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $red_ninjas = RedNinja::with(['league', 'tip'])->get();
            return response()->json($red_ninjas);

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
        try {

            $red_ninja = new RedNinja([
                'league_id' => $request->league_id,
                'fixtures' => $request->fixtures,
                'tip_id' => $request->tip_id,
                'results' => $request->results,
            ]);
            $red_ninja->save();
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
            $red_ninja =  RedNinja::with(['league', 'tip'])->findOrFail($id);
            return response()->json($red_ninja);

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
    public function edit(RedNinja $redNinja)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $red_ninja = RedNinja::findOrFail($id);
            $red_ninja->league_id = $request->league_id;
            $red_ninja->fixtures = $request->fixtures;
            $red_ninja->tip_id = $request->tip_id;
            $red_ninja->results = $request->results;
            $red_ninja->save();

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
            $red_ninja = RedNinja::findOrFail($id);
            $red_ninja->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted.'], 200);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

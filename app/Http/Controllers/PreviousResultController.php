<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use App\Models\PreviousResult;
use Illuminate\Http\Request;

class PreviousResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $previous_results = PreviousResult::with(['league', 'tip'])->get();
            return response()->json($previous_results);

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

            $previous_result = new PreviousResult([
                'league_id' => $request->league_id,
                'fixtures' => $request->fixtures,
                'tip_id' => $request->tip_id,
                'results' => $request->results,
            ]);
            $previous_result->save();
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
            $previousResult =  PreviousResult::with(['league', 'tip'])->findOrFail($id);
            return response()->json($previousResult);

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
    public function edit(PreviousResult $previousResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $previousResult = PreviousResult::findOrFail($id);
            $previousResult->league_id = $request->league_id;
            $previousResult->fixtures = $request->fixtures;
            $previousResult->tip_id = $request->tip_id;
            $previousResult->results = $request->results;
            $previousResult->save();

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
            $previousResult = PreviousResult::findOrFail($id);
            $previousResult->delete();
            return response()->json(['success' => true, 'message' => 'Record deleted.'], 200);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

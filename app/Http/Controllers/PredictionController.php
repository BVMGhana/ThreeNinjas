<?php

namespace App\Http\Controllers;

use App\Models\Prediction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PredictionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'ninja' => 'required|string|max:10',
            'count' => 'required|numeric',
        ]);

        try {

            $prediction = new Prediction([
                'ninja' => $request->ninja,
                'count' => $request->count
            ]);
            $prediction->save();
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
    public function show(Prediction $prediction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Prediction $prediction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, Prediction $prediction)
    public function update(Request $request, $ninja)
    {
        try {
            $prediction = Prediction::where('ninja', $ninja)->first();
            $prediction->count = $prediction->count + 1;
            $prediction->save();

            return response()->json(['success' => true, 'message' => 'Record added.'], 201);

        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Prediction $prediction)
    {
        //
    }
}

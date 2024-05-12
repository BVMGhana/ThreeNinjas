<?php

namespace App\Http\Controllers;

use App\Models\Fixture;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $fixtures = Fixture::all();
            return response()->json($fixtures);

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

            $fixture = new Fixture(['title' => $request->title]);
            $fixture->save();
            return response()->json(['success' => true, 'message' => 'Fixture added.'], 201);

        } catch (Exception $e) {
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
            $fixture =  Fixture::findOrFail($id);
            return response()->json($fixture);

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
    public function edit(Fixture $fixture)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $fixture = Fixture::findOrFail($id);
            $fixture->title = $request->title;
            $fixture->save();

            return response()->json(['success' => true, 'message' => 'Fixture updated.'], 201);

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
    public function destroy($id)
    {
        try {
            $fixture = Fixture::findOrFail($id);
            $fixture->delete();
            return response()->json(['success' => true, 'message' => 'Fixture deleted.'], 200);

        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

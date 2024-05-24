<?php

namespace App\Http\Controllers;

use App\Models\Betcode;
use Illuminate\Http\Request;

class BetcodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $betcodes = Betcode::all();
            return response()->json($betcodes);

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
        $request->validate([
            'ninja' => 'required|string|max:10',
            'code' => 'required|string|max:10',
        ]);

        try {

            $betcode = new Betcode(['ninja' => $request->ninja, 'code' => $request->code]);
            $betcode->save();
            return response()->json(['success' => true, 'message' => 'Betcode added.'], 201);

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
            $betcode = Betcode::findOrFail($id);
            return response()->json($betcode);

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
    public function edit(Betcode $betcode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'ninja' => 'required|string|max:10',
            'code' => 'required|string|max:10',
        ]);
        
        try {
            $betcode = Betcode::findOrFail($id);
            $betcode->ninja = $request->ninja;
            $betcode->code = $request->code;
            $betcode->save();

            return response()->json(['success' => true, 'message' => 'Betcode updated.'], 201);

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
            $betcode = Betcode::findOrFail($id);
            $betcode->delete();
            return response()->json(['success' => true, 'message' => 'Betcode deleted.'], 200);

        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

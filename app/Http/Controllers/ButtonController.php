<?php

namespace App\Http\Controllers;

use App\Models\Button;
use Illuminate\Http\Request;

class ButtonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $buttons = Button::all();
            return response()->json($buttons);

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
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'background' => 'required|string|max:7',
            'foreground' => 'required|string|max:7',
            'priority' => 'required|numeric',
        ]);

        try {
            $button = new Button([
                'title' => $request->title, 'url' => $request->url,
                'background' => $request->background, 'foreground' => $request->foreground,
                'priority' => $request->priority
            ]);
            $button->save();
            return response()->json(['success' => true, 'message' => 'Button added.'], 201);

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
            $button =  Button::findOrFail($id);
            return response()->json($button);

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
    public function edit(Button $button)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $button = Button::findOrFail($id);
            $button->title = $request->title;
            $button->url = $request->url;
            $button->background = $request->background;
            $button->foreground = $request->foreground;
            $button->priority = $request->priority;
            $button->save();

            return response()->json(['success' => true, 'message' => 'Button updated.'], 201);

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
            $button = Button::findOrFail($id);
            $button->delete();
            return response()->json(['success' => true, 'message' => 'Button deleted.'], 200);

        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

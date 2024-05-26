<?php

namespace App\Http\Controllers;

use App\Models\Button;
use Illuminate\Http\Request;

function capitalize($string) {
    return ucfirst($string);
}

function transform($string) {
    $words = explode('-', $string);
    $formattedWords = array_map('ucfirst', $words);
    return implode(' ', $formattedWords);
}

class ButtonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $buttons = Button::orderBy('priority')->get();
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
            'company' => 'required|string|max:100',
            'code' => 'required|string|max:30',
            'ninja' => 'required|string|max:50'
        ]);

        try {

            $existing_button = Button::where(['ninja' => $request->ninja, 'company' => $request->company])->first();

            if ($existing_button) {
                $company_name = transform($existing_button->company);
                $ninja_name = capitalize($existing_button->ninja);
                return response()->json(['message' => "Button already exists for {$company_name} under {$ninja_name} Ninjas"]);
            }

            $existing_button = Button::where(['ninja' => $request->ninja, 'priority' => $request->priority])->first();
            
            if ($existing_button) {
                $priority = $existing_button->priority;
                $ninja_name = capitalize($existing_button->ninja);
                return response()->json(['message' => "Button already exists for Priority {$priority} under {$ninja_name} Ninjas"]);
            }

            $button = new Button([
                'title' => $request->title, 'url' => $request->url,
                'background' => $request->background, 'foreground' => $request->foreground,
                'priority' => $request->priority, 'company' => $request->company, 'code' => $request->code,
                'ninja' => $request->ninja
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
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
            'background' => 'required|string|max:7',
            'foreground' => 'required|string|max:7',
            'priority' => 'required|numeric',
            'company' => 'required|string|max:100',
            'code' => 'required|string|max:30',
            'ninja' => 'required|string|max:50'
        ]);

        try {
            $button = Button::findOrFail($id);
            $button->title = $request->title;
            $button->url = $request->url;
            $button->background = $request->background;
            $button->foreground = $request->foreground;
            $button->priority = $request->priority;
            $button->company = $request->company;
            $button->code = $request->code;
            $button->ninja = $request->ninja;
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

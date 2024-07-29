<?php

namespace App\Http\Controllers;

use App\Models\BetButtonClick;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BetButtonClickController extends Controller
{

    public function count($company)
    {
        try {
            $now = Carbon::now();
            // $yesterday = $now->copy()->subDay();
            $yesterday = $now->subDays(1);

            $countLast24Hours = BetButtonClick::where('created_at', '>=', $yesterday)->where('company', $company)->count();

            $countBefore24Hours = BetButtonClick::where('created_at', '<', $yesterday)->where('company', $company)->count();

            $percentageLast24Hours = 0;
            if ($countBefore24Hours > 0) {
                $percentageLast24Hours = ($countLast24Hours / $countBefore24Hours) * 100;
            } else {
                if ($countLast24Hours == 0) {
                    $percentageLast24Hours = 0;
                } else {
                    $percentageLast24Hours = 100;
                }
            }

            $clicks_count = BetButtonClick::where('company', $company)->count();

            return response()->json([
                'clicks_count' => $clicks_count,
                'countLast24Hours' => $countLast24Hours,
                'countBefore24Hours' => $countBefore24Hours,
                'percentageLast24Hours' => round($percentageLast24Hours)
            ]);
            
        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    public function count_all()
    {
        try {
            $now = Carbon::now();
            $yesterday = $now->subDays(1);

            $countLast24Hours = BetButtonClick::where('created_at', '>=', $yesterday)->count();

            $countBefore24Hours = BetButtonClick::where('created_at', '<', $yesterday)->count();

            $percentageLast24Hours = 0;
            if ($countBefore24Hours > 0) {
                $percentageLast24Hours = ($countLast24Hours / $countBefore24Hours) * 100;
            } else {
                if ($countLast24Hours == 0) {
                    $percentageLast24Hours = 0;
                } else {
                    $percentageLast24Hours = 100;
                }
            }

            $clicks_count = BetButtonClick::count();

            return response()->json([
                'clicks_count' => $clicks_count,
                'countLast24Hours' => $countLast24Hours,
                'countBefore24Hours' => $countBefore24Hours,
                'percentageLast24Hours' => round($percentageLast24Hours)
            ]);
            
        } catch (Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }


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
            'user_id' => 'required|numeric',
            'ninja' => 'required|string|max:50',
            'company' => 'required|string|max:100'
        ]);

        try {

            $button_click = new BetButtonClick([
                'user_id' => $request->user_id,
                'ninja' => $request->ninja,
                'company' => $request->company
            ]);
            $button_click->save();
            return response()->json(['success' => true ], 201);

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
    public function show(BetButtonClick $betButtonClick)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BetButtonClick $betButtonClick)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BetButtonClick $betButtonClick)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BetButtonClick $betButtonClick)
    {
        //
    }
}

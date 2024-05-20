<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\BlackNinja;
use App\Models\RedNinja;
use App\Models\WhiteNinja;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $users = User::all();
            return response()->json($users);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Return the total number of the resource.
     */
    public function count()
    {
        try {

            $users_count = User::count();
            return response()->json($users_count);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Return the total number of the resource.
     */
    public function count_all()
    {
        try {
            $white_ninja_count = WhiteNinja::count();
            $red_ninja_count = RedNinja::count();
            $black_ninja_count = BlackNinja::count();
            $total_predictions = $white_ninja_count + $red_ninja_count + $black_ninja_count;
            return response()->json($total_predictions);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }


    /**
     * Return the three most recently registered users.
     */
    public function recent()
    {
        try {

            $recent_users = User::latest()->take(3)->get();
            return response()->json($recent_users);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

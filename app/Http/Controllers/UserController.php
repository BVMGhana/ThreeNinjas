<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\BlackNinja;
use App\Models\RedNinja;
use App\Models\WhiteNinja;
use App\Models\Prediction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\PredictionController;

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
            $now = Carbon::now();
            $yesterday = $now->subDays(1);

            $countLast24Hours = User::where('created_at', '>=', $yesterday)->count();

            $countBefore24Hours = User::where('created_at', '<', $yesterday)->count();

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

            $users_count = User::count();

            return response()->json([
                'users_count' => $users_count,
                'countLast24Hours' => $countLast24Hours,
                'countBefore24Hours' => $countBefore24Hours,
                'percentageLast24Hours' => $percentageLast24Hours
            ]);

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
            $white_ninja_count = Prediction::where("ninja", "white")->first()->count;
            $red_ninja_count = Prediction::where("ninja", "red")->first()->count;
            $black_ninja_count = Prediction::where("ninja", "black")->first()->count;
            $total_predictions = $white_ninja_count + $red_ninja_count + $black_ninja_count;
            return response()->json($total_predictions);

            // $app_url = env('SERVER_BASE_URL', '');

            // $predictions = Http::get("{$app_url}/api/predictions-count");
            // $predictions = Http::get("{$app_url}/api/users-count");
            // return response()->json($this->count());
            // $predictions = Http::get("http://127.0.0.1:8000/api/users-count");
            // $predictions = Http::get("https://3ninjaodds.com/api/users-count");

            // $predictions = Http::withOptions(['verify' => false])->get("https://3ninjaodds.com/api/users-count");
            // $predictions = Http::withOptions(['verify' => false])->get("http://localhost:8000/api/users-count");
            // $predictions = Http::withOptions(['verify' => false])->get("http://127.0.0.1:8000/api/users-count-aa");
            
            // return response()->json($predictions->json());

            // This works
            // $request = new Request(["ninja" => "red", "count" => 0]);
            // $predictionController = new PredictionController();
            // $predictionController->store($request);
            // return response()->json($request);

            // This works
            // $request = new Request();
            // $predictionController = new PredictionController();
            // $predictionController->update($request, "white");
            // return response()->json($predictionController);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Return the three most recently registered users.
     */
    public function most_recent()
    {
        try {

            $most_recent_users = User::latest()->take(3)->get();
            return response()->json($most_recent_users);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }

    /**
     * Return the ten recently registered users.
     */
    public function recent()
    {
        try {

            $recent_users = User::latest()->take(10)->get();
            return response()->json($recent_users);

        } catch (\Exception $e) {
            // Writing detailed error message to the developer log and 
            // returning a simple error message to the client
            Log::error('Error occurred: ' . $e->getMessage());
            return response()->json(['error' => 'Oops! Something went wrong.'], 500);
        }
    }
}

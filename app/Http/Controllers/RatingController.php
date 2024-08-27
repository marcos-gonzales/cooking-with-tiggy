<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Request;

class RatingController extends Controller
{
    public function vote()
    {
        $user = User::where('email', Request::get('email'))->first();

        $vote = Rating::where('recipe_id', Request::get('recipe_id'))
            ->where('user_id', $user->id)->first();

        if($vote) {
            return redirect()->back()->with('error', 'you\'ve already voted');
        }
       
        Request::validate([
            'up_vote' => 'nullable|boolean',
            'down_vote' => 'nullable|boolean',
            'recipe_id' => 'required',
        ]);

        Rating::create([
            'up_vote' => Request::get('up_vote') ?? null,
            'down_vote' => Request::get('down_vote') ?? null,
            'recipe_id' => Request::get('recipe_id'),
            'user_id' => $user->id
        ]);

        return redirect()->back()->with('success', 'thanks for voting');
    }
}

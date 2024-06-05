<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Api\V1\ActionUser;
use App\Models\Api\V1\Video;
// use App\Models\Api\V1\Review;
use App\Models\Api\V1\User;

class RatingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(User $user)
    {
        $ratings = $user->ratings()
            ->with('film:id,name')
            ->select('id', 'film_id', 'ball','created_at')
            ->get();

        $data = [
            'ratings' => $ratings->map(function ($rating) {
                return [
                    'id' => $rating->id,
                    'film' => [
                        'id' => $rating->film->id,
                        'name' => $rating->film->name,
                    ],
                    'score' => $rating->ball,
                    'created_at' => $rating->created_at,
                ];
            }),
        ];

        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, User $user)
    {
        $request->validate([
            'video_id' => ['required', Rule::exists("videos", "id")],
        ]);

        

        $review = Rating::create([
            'video_id' => $request->video_id,
            'user_id' => $user->id,
            'ball' => $request->ball
        ]);

        $film = Video::find($request->video_id);

        return \response([
            'id' => $review->id,
            'film' => [
                'id' => $film->id,
                'name' => $film->name,
            ],
            'score' => $request->ball,
            'createdAt' => $review->created_at
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, Rating $rating)
    {
        if ($rating->user_id != $user->id) {
            return response([
                'message' => 'Access denied'
            ]);
        }

        if ($user->id == auth()->id() && $rating->user_id == $user->id) {
            $rating->delete();
            return response([
                'status' => 'success'
            ]);
        }
    }
}

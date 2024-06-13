<?php

namespace App\Http\Controllers\Admin\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\Api\V1\Gender;
use App\Models\Api\V1\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        if (auth()->id() == $user->id) {
            $gender = Gender::find($user->gender_id);

            $data = [
                // 'id' => $user->id,
                'fio' => $user->fio,
                'email' => $user->email,
                'birthday' => $user->birthday,
                'password' => $user->password,
                'gender' => [
                    'id' => $gender->id,
                    'name' => $gender->name
                ],
                // 'reviewCount' => $user->reviews()->count(),
                // 'ratingCount' => $user->ratings()->count()
            ];

            return response()->json($data);
        } else {
            return response([
                'message' => 'access denied'
            ]);
        }


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'fio' => ['required', 'min:2', 'max:150'],
            'email' => ['required', 'email', 'min:4', 'max:50', Rule::unique('users', 'email')],
            'birthday' => ['required', 'date'],
            'password' => ['required', 'min:6', 'max:200'],
            'genderId' => ['required', Rule::exists('genders', 'id')]
        ]);

        $request['email'] = substr($request['email'], 12);

        $id = auth()->id(); //  $request['id']
        $user = User::find($id);
        $user->update($request->all());
        return response([
            'status' => "success"
        ]);
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'currentPassword' => ['required', 'min:6', 'max:200'],
            'newPassword' => ['required', 'min:6', 'max:200']
        ]);

        $id = auth()->id(); //  $request['id']
        $user = User::find($id);

        if (!$user || !Hash::check($request['currentPassword'], $user->password)) {
            return \response([
                "status" => "invalid",
                "message" => "Wrong password"
            ], 401);
        }

        $password = ['password' => bcrypt($request['newPassword'])];

        $user->update($password);
        return response([
            'status' => "success"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        auth()->user()->tokens()->delete();
        auth()->user()->delete();
        return response([
            "status" => 'success'
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function addUser(Request $request)
    {
        $path = $request->input('pathToFile');
        $nickname = $request->input('nickname');
        $filename = $request->input('filename');
        $type = $request->input('type');

        return 'alarm';
    }
}

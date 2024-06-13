<?php

namespace App\Http\Controllers\Mobile\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Gender;

class GenderController extends Controller
{
    /*
     * Display a listing of the resource.
     */
    public function index()
    {
        return ["genders" => Gender::all()];
    }
}

<?php

namespace App\Http\Controllers\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Gender;
use Illuminate\Http\Request;

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

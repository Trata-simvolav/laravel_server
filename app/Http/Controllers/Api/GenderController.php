<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Api\Gender;
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

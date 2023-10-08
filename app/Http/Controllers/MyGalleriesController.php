<?php

namespace App\Http\Controllers;


use App\Models\Gallery;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class MyGalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Gallery $gallery)
    {
        $user = JWTAuth::parseToken()->authenticate();
        $page = $request->input('page', 1);
        $term = $request->input('term', '');

        return $gallery->search(($page - 1) * 10, 10, $term, $user);
    }
}

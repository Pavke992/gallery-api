<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\User;
use Illuminate\Http\Request;

class AuthorsGalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $id = request()->input('id');
        $page = request()->input('page', 1);
        $term = request()->input('term', '');

        $user = User::find($id);

        $skip = ($page - 1) * 10;
        $take = 10;

        $count = Gallery::where('user_id', $id)->count();

        $metadata = [
            'total' => $count
        ];

        if($term) {
            return response()->json([
                'data' => Gallery::search($skip, $take, $term, $user),
                'metadata' => $metadata
            ]);
        } else {

            return response()->json([
                'data' => Gallery::where('user_id', $id)->skip($skip)->take($take)->get(),
                'metadata' => $metadata
            ]);
        }
    }
}

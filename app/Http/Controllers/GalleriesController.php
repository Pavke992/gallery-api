<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGalleryRequest;
use App\Http\Requests\UpdateGalleryRequest;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use App\Models\Image;
use Tymon\JWTAuth\Facades\JWTAuth;

class GalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $count = Gallery::get()->count();
        $term = request()->input('term');
        $skip = request()->input('skip', 0);
        $take = request()->input('take', 10);

        $metadata = [
            'total' => $count
        ];

        if ($term) {
            return response()->json([
                'data' => Gallery::search($term, $skip, $take),
                'metadata' => $metadata
            ]);
        } else {
            return response()->json([
                'data' => Gallery::skip($skip)->take($take)->get(),
                'metadata' => $metadata
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGalleryRequest $request)
    {

        $user = JWTAuth::parseToken()->authenticate();

        $data = $request->validated();

        $gallery = Gallery::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'owner_id' => auth()->user()->id
        ]);

        //    creating images

        $imagesData = $request->input('images');
        $images = [];

        foreach ($imagesData as $imageData) {
            $images[] = new Image($imageData);
        }

        //    connecting images with gallery

        $gallery->images()->saveMany($images);

        return $gallery;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $gallery = Gallery::with([

            'images' => function ($query) {
                $query->orderBy('order');
            },
            'comments',
            'owner'
        ])->findOrFail($id);

        if (!isset($gallery)) {
            abort(404, "Gallery doesn't exist");
        }

        return new GalleryResource($gallery);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGalleryRequest $request, string $id)
    {
        $data = $request->validated();

        $gallery = Gallery::findOrFail($id);

        $gallery->update([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        $gallery->images()->delete();

        $imagesArray = $data['images'];
        $images = [];

        foreach ($imagesArray as $image) {
            $newImage = new Image($image);
            $images[] = $newImage;
        }

        // connect new images with gallery

        $gallery->images()->saveMany($images);

        return new GalleryResource($gallery);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $gallery = Gallery::findOrFail($id);
        return $gallery->delete();
    }
}

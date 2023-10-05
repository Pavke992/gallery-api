<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'owner_id'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->with('owner');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function getCoverImageAttribute()
    {
        return $this->images()->orderBy('order', 'asc')->first();
    }

    public static function search($term, $skip, $take){
        return self::where('name', 'LIKE', '%'.$term.'%')->skip($skip)->take($take)->get();
    }

}

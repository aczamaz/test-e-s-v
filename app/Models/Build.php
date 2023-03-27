<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Build extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    
    protected $fillable = [
        'name',
        'img'
    ];
    public function cities()
    {
        return $this->belongsToMany(City::class, 'builds_cities', 'build_id', 'city_id');
    }
    public function types()
    {
        return $this->belongsToMany(Type::class, 'builds_types', 'build_id', 'type_id');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('media')->singleFile();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Candidate extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'detail',
        'vote_count'
    ];

    /**
     * image
     *
     * @return Attribute
     */
    protected function image(): Attribute
    {
        // if($image == ''){
        //     return '';
        // }else{
        //     return Attribute::make(
        //         get: fn ($image) => asset('/storage/candidate/' . $image),
        //     );
        // }
        return Attribute::make(
            get: fn ($image) => asset('/storage/' . $image),
        );
    }
}

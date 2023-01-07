<?php

namespace App;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AppReferenceType extends Model
{
    use Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded = [];
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $table = 'base_app_reference_types';
}

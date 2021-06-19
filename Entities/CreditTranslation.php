<?php

namespace Modules\Icredit\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;


class CreditTranslation extends Model
{

    public $timestamps = false;
    protected $fillable = [
        'description',

    ];
    protected $table = 'icredit__credit_translations';
}

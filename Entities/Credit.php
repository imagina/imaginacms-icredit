<?php

namespace Modules\Icredit\Entities;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Illuminate\Support\Str;

class Credit extends Model
{
    use Translatable, NamespacedEntity;

    protected $table = 'icredit__credits';
    protected static $entityNamespace = 'asgardcms/icreditCredit';
    public $translatedAttributes = [
        'description',
    ];
    protected $fillable = [
        'customer_id',
        'admin_id',
        'status',
        'date',
        'amount',
        'related_id',
        'related_type',
    ];

    public function customer()
    {
        $driver = config('asgard.user.config.driver');
        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User",'customer_id');
    }

    public function getOptioqnsAttribute($value)
    {
        try {
            return json_decode(json_decode($value));
        } catch (\Exception $e) {
            return json_decode($value);
        }
    }
}
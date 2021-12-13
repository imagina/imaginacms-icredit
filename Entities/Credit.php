<?php

namespace Modules\Icredit\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Traits\NamespacedEntity;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;
use Illuminate\Support\Str;

class Credit extends Model
{
  use NamespacedEntity,BelongsToTenant;
  
  protected $table = 'icredit__credits';
  protected static $entityNamespace = 'asgardcms/icreditCredit';

  protected $fillable = [
    'description',
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
    return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'customer_id');
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
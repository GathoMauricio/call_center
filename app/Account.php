<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $table = 'accounts';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'status',
        'phone',
        'name',
        'account',
        'amount',
        'location',
        'created_at',
        'update_at',
    ];
    protected static function boot()
	{
		parent::boot();
        static::creating(function ($query) {
            $query->status = 'active';
		});
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reminder extends Model
{
    protected $table = 'reminders';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'account_id',
        'user_id',
        'date',
        'body',
        'created_at',
        'updated_at'
    ];
    protected static function boot()
	{
		parent::boot();

		static::creating(function ($query) {
            $query->user_id = \Auth::user()->id;
        });
    }
    public function account()
    {
        return $this->belongsTo(
            'App\Account',
            'account_id',
            'id'
        )
            ->withDefault();
    }
    public function user()
    {
        return $this->belongsTo(
            'App\User',
            'user_id',
            'id'
        )
            ->withDefault();
    }
}

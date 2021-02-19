<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountFollow extends Model
{
    protected $table = 'account_follows';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'author_id',
        'account_id',
        'codification',
        'body',
        'created_at',
        'updated_at'
    ];
    protected static function boot()
	{
		parent::boot();

		static::creating(function ($query) {
            $query->author_id = \Auth::user()->id;
        });
    }
    public function author()
    {
        return $this->belongsTo(
            'App\User',
            'author_id',
            'id'
        )
            ->withDefault();
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
}

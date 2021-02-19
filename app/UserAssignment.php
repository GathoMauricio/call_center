<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAssignment extends Model
{
    protected $table = 'user_assignments';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'user_id',
        'account_id',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(
            'App\User',
            'user_id',
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

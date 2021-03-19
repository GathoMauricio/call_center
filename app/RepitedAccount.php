<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RepitedAccount extends Model
{
    protected $table = 'repited_accounts';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'account_id',
        'created_at',
        'updated_at'
    ];
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

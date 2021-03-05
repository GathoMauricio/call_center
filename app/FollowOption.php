<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FollowOption extends Model
{
    protected $table = 'follow_options';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'option',
        'color',
        'created_at',
        'updated_at'
    ];
}

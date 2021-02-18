<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapingList extends Model
{
    protected $table = 'scraping_lists';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'account',
        'name',
        'amount',
        'message',
        'timestamp_id'
    ];
    protected $hidden = [
        'id',
        'timestamp_id',
        'created_at',
        'updated_at'
    ];
}

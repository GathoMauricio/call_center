<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapingCredential extends Model
{
    protected $table = 'scraping_credentials';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'user',
        'password',
        'created_at',
        'updated_at'
    ];
}

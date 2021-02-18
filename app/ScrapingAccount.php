<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScrapingAccount extends Model
{
    protected $table = 'scraping_accounts';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'account',
        'name',
        'created_at',
        'updated_at'
    ];
}

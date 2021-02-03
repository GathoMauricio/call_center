<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sales';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = [
        'id',
        'author_id',
        'description',
        'amount',
        'date',
        'created_at',
        'updated_at'
    ];
    protected static function boot()
	{
		parent::boot();

		static::creating(function ($query) {
            $query->author_id = \Auth::user()->id;
            $query->date = date('Y-m').'-01';
		});
	}
    public function goal()
    {
        return $this->belongsTo(
            'App\Goal',
            'date',
            'date'
        )
            ->withDefault();
    }
}

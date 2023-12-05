<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'status'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id' );
    }
    public function assigned_enginner()
    {
        return $this->belongsTo('App\Models\User','user_id' );
    }
    public function store()
    {
        return $this->belongsTo('App\Models\Store','store_id' );
    }
}

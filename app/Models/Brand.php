<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'estado',
        'created_at'
    ];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'brand_users'
        );
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}

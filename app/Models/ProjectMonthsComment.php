<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMonthsComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'months',
        'comment',
        'estado',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

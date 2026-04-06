<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DocumentVersion extends Model
{
    protected $fillable = [
        'document_id',
        'file_path',
        'version'
    ];

    protected $hidden = [
        'updated_at',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}

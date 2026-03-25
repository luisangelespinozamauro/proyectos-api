<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nr',
        'brand',
        'model',
        'product_family',
        'estimated_volume',
        'questionnaire_completion',
        'nda_status',
        'mou_status',
        'tca_status',
        'contract_status',
        'bom_status',
        'price_agreement',
        'project_status',
        'assembly_approach',
        'assembly_line',
        'layout',
        'production_2026',
        'potential_volume',
        'comments',
        'next_steps',
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}

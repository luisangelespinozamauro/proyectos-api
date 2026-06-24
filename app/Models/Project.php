<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'nr',
        'brand_id',
        'model',
        'product_family',
        'estimated_volume',
        'questionnaire_completion',
        'nda_status',
        'mou_status',
        'tca_status',
        'contract_status',
        'contract_status2',
        'bom_status',
        'price_agreement',
        'project_status',
        'assembly_approach',
        'assembly_line',
        'layout',
        'potential_volume',
        'due_diligence',
        'comments',
        'next_steps',
        'created_at',
        'estado',

        'main_contact_supervisor',
        'model_family',
        'models',
        'plant_line',
        'trademark_license_agreement',
        'homologation_status',
        'estimated_sop',
        'project_mgr',
        'pending_points_legal',
        'support_requested'
    ];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    public function yearlyEstimations()
    {
        return $this->hasMany(ProjectYearlyEstimation::class);
    }

    public function monthsComments()
    {
        return $this->hasMany(ProjectMonthsComment::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}

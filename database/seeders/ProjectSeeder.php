<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Project;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'nr' => 1,
                'brand' => 'Toyota',
                'model' => 'Hilux',
                'product_family' => 'Pickup',
                'estimated_volume' => 12000,
                'questionnaire_completion' => 'Complete',
                'nda_status' => 'Signed',
                'mou_status' => 'Pending',
                'tca_status' => 'Pending',
                'contract_status' => 'Draft',
                'bom_status' => 'In Progress',
                'price_agreement' => 'Under negotiation',
                'project_status' => 'Project confirmed',
                'assembly_approach' => 'CKD',
                'assembly_line' => 'Line 1',
                'layout' => 'Layout A',
                'production_2026' => 8000,
                'potential_volume' => 15000,
                'comments' => 'Proyecto prioritario',
                'next_steps' => 'Firmar MOU',
            ],
            [
                'nr' => 2,
                'brand' => 'Nissan',
                'model' => 'Versa',
                'product_family' => 'Sedan',
                'estimated_volume' => 20000,
                'questionnaire_completion' => 'Partial',
                'nda_status' => 'Signed',
                'mou_status' => 'Signed',
                'tca_status' => 'Pending',
                'contract_status' => 'Draft',
                'bom_status' => 'Complete',
                'price_agreement' => 'Defined',
                'project_status' => 'Project confirmed',
                'assembly_approach' => 'SKD',
                'assembly_line' => 'Line 2',
                'layout' => 'Layout B',
                'production_2026' => 15000,
                'potential_volume' => 22000,
                'comments' => 'Buen avance',
                'next_steps' => 'Cerrar contrato',
            ],
            [
                'nr' => 3,
                'brand' => 'Kia',
                'model' => 'Rio',
                'product_family' => 'Hatchback',
                'estimated_volume' => 10000,
                'questionnaire_completion' => 'Pending',
                'nda_status' => 'Pending',
                'mou_status' => 'Pending',
                'tca_status' => 'Pending',
                'contract_status' => 'Pending',
                'bom_status' => 'Pending',
                'price_agreement' => 'Pending',
                'project_status' => 'Project confirmed',
                'assembly_approach' => 'CKD',
                'assembly_line' => 'Line 3',
                'layout' => 'Layout C',
                'production_2026' => 0,
                'potential_volume' => 12000,
                'comments' => 'En fase inicial',
                'next_steps' => 'Enviar NDA',
            ],
        ];

        foreach ($projects as $project) {
            Project::create($project);
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::with([
            'documents.versions'
        ])
        ->select(
            'id',
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
            'created_at',
            'estado',
        )
            ->where('estado', '!=', 0)
            ->orderBy('id', 'asc')
            ->get();

        return response()->json($projects, 200);
    }

    public function store(Request $request)
    {
        $validated = $this->validateProject($request);

        $project = Project::create($validated);

        return response()->json([
            'message' => 'Proyecto creado correctamente',
            'data'    => $project
        ], 201);
    }

    public function show($id)
    {
        $project = Project::select(
            'id',
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
            'created_at',
            'estado',
        )
            ->where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        return response()->json($project, 200);
    }

    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);

        $validated = $this->validateProject($request, $id);

        $project->update($validated);

        return response()->json([
            'message' => 'Proyecto actualizado correctamente',
            'data'    => $project
        ]);
    }

    public function destroy($id)
    {
        $project = Project::where('id', $id)
            ->where('estado', '!=', 0)
            ->firstOrFail();

        $project->update(['estado' => 0]);

        return response()->json([
            'message' => 'Proyecto eliminado correctamente'
        ], 200);
    }

    private function validateProject(Request $request, $id = null)
    {
        return $request->validate([
            'nr' => 'nullable',
            'brand' => 'required',
            'model' => 'nullable',
            'product_family' => 'nullable',
            'estimated_volume' => 'nullable',
            'questionnaire_completion' => 'nullable',
            'nda_status' => 'nullable',
            'mou_status' => 'nullable',
            'tca_status' => 'nullable',
            'contract_status' => 'nullable',
            'bom_status' => 'nullable',
            'price_agreement' => 'nullable',
            'project_status' => 'nullable',
            'assembly_approach' => 'nullable',
            'assembly_line' => 'nullable',
            'layout' => 'nullable',
            'production_2026' => 'nullable',
            'potential_volume' => 'nullable',
            'comments' => 'nullable',
            'next_steps' => 'nullable',
        ], [
            'brand.required' => 'La marca es requerida',
        ]);
    }
}

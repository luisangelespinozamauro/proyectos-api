<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::select(
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
            ->orderBy('id', 'desc')
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
            'nr' => 'required',
            'brand' => 'required',
            'model' => 'required',
            'product_family' => 'nullable',
            'estimated_volume' => 'required',
            'questionnaire_completion' => 'nullable',
            'nda_status' => 'required',
            'mou_status' => 'nullable',
            'tca_status' => 'nullable',
            'contract_status' => 'nullable',
            'bom_status' => 'nullable',
            'price_agreement' => 'nullable',
            'project_status' => 'required',
            'assembly_approach' => 'nullable',
            'assembly_line' => 'nullable',
            'layout' => 'nullable',
            'production_2026' => 'nullable',
            'potential_volume' => 'nullable',
            'comments' => 'nullable',
            'next_steps' => 'nullable',
        ], [
            'nr.required' => 'El número de proyecto es requerido',
            'brand.required' => 'La marca es requerida',
            'model.required' => 'El modelo es requerido',
            'estimated_volume.required' => 'El volumen estimado es requerido',
            'nda_status.required' => 'El estado del NDA es requerido',
            'project_status.required' => 'El estado del proyecto es requerido',
        ]);
    }
}

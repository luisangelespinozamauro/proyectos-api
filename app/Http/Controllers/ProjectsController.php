<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
                'due_diligence',
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

    public function productFamilies()
    {
        $families = Project::select('product_family')
            ->where('estado', '!=', 0)
            ->whereNotNull('product_family')
            ->distinct()
            ->orderBy('product_family', 'asc')
            ->pluck('product_family');

        return response()->json($families, 200);
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $validated = $this->validateProject($request);

            $project = Project::create($validated);

            $allowedTypes = ['QUESTIONNAIRE', 'NDA', 'MOU', 'TCA', 'CONTRACT', 'BOM', 'PRICE', 'LAYOUT'];

            foreach ($request->documents as $type => $file) {

                $type = strtoupper($type);

                if (!in_array($type, $allowedTypes)) {
                    continue;
                }

                if (!$file) continue;

                $path = $file->store("documents/", 'public');

                $document = Document::create([
                    'project_id' => $project->id,
                    'type' => $type,
                    'name' => $file->getClientOriginalName(),
                    'current_version' => 1,
                ]);

                DocumentVersion::create([
                    'document_id' => $document->id,
                    'file_path' => $path,
                    'version' => 1,
                ]);
            }

            DB::commit();

            return response()->json([
                'message' => 'Proyecto creado correctamente',
                'data' => $project->load('documents.versions')
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al crear proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $project = Project::with([
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
                'due_diligence',
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
        DB::beginTransaction();

        try {
            $project = Project::findOrFail($id);

            $validated = $this->validateProject($request, $id);

            $project->update($validated);

            $allowedTypes = ['QUESTIONNAIRE', 'NDA', 'MOU', 'TCA', 'CONTRACT', 'BOM', 'PRICE', 'LAYOUT'];

            if ($request->has('documents')) {

                foreach ($request->file('documents') as $type => $file) {

                    $type = strtoupper($type);

                    if (!in_array($type, $allowedTypes)) {
                        continue;
                    }

                    if (!$file) continue;

                    $document = Document::where('project_id', $project->id)
                        ->where('type', $type)
                        ->first();

                    $path = $file->store("documents/", 'public');

                    if ($document) {

                        $newVersion = $document->current_version + 1;

                        DocumentVersion::create([
                            'document_id' => $document->id,
                            'file_path' => $path,
                            'version' => $newVersion,
                        ]);

                        $document->update([
                            'current_version' => $newVersion,
                            'name' => $file->getClientOriginalName()
                        ]);
                    } else {

                        $document = Document::create([
                            'project_id' => $project->id,
                            'type' => $type,
                            'name' => $file->getClientOriginalName(),
                            'current_version' => 1,
                        ]);

                        DocumentVersion::create([
                            'document_id' => $document->id,
                            'file_path' => $path,
                            'version' => 1,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'message' => 'Proyecto actualizado correctamente',
                'data' => $project->load('documents.versions')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al actualizar proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
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
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,svg',
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
            'due_diligence' => 'nullable',
            'comments' => 'nullable',
            'next_steps' => 'nullable',
        ], [
            'brand.required' => 'La marca es requerida',
        ]);
    }
}

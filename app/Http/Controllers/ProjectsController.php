<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentVersion;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProjectsController extends Controller
{
    public function index()
    {
        $projects = Project::with([
            'documents.versions',
            'yearlyEstimations',
            'monthsComments',
            'brand:id,name',
            'brand.users:id,name',
        ])
            ->select(
                'id',
                'brand_id',
                'nr',
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

            if ($request->filled('yearly_estimations')) {
                foreach ($request->yearly_estimations as $item) {
                    $project->yearlyEstimations()->create([
                        'year' => $item['year'],
                        'amount' => $item['amount'],
                    ]);
                }
            }

            if ($request->filled('months_comments')) {
                foreach ($request->months_comments as $item) {
                    $project->monthsComments()->create([
                        'months' => $item['months'],
                        'comment' => $item['comment'],
                    ]);
                }
            }

            $allowedTypes = ['QUESTIONNAIRE', 'NDA', 'MOU', 'TCA', 'CONTRACT', 'BOM', 'PRICE', 'LAYOUT'];

            if ($request->has('documents')) {

                foreach ($request->file('documents') as $type => $file) {

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
            }

            DB::commit();

            return response()->json([
                'message' => 'Proyecto creado correctamente',
                'data' => $project->load('documents.versions')
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $e->errors()
            ], 422);
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
            'documents.versions',
            'yearlyEstimations',
            'monthsComments',
            'brand:id,name',
        ])
            ->select(
                'id',
                'brand_id',
                'nr',
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

            if ($request->filled('yearly_estimations')) {
                $project->yearlyEstimations()->delete();
                foreach ($request->yearly_estimations as $item) {
                    $project->yearlyEstimations()->create([
                        'year' => $item['year'],
                        'amount' => $item['amount'],
                    ]);
                }
            }

            if ($request->filled('months_comments')) {
                $project->monthsComments()->delete();
                foreach ($request->months_comments as $item) {
                    $project->monthsComments()->create([
                        'months' => $item['months'],
                        'comment' => $item['comment'],
                    ]);
                }
            }

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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al actualizar proyecto',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    private function validateProject(Request $request, $id = null)
    {
        return $request->validate([
            'documents' => 'nullable|array',
            'documents.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,svg',
            'brand_id' => 'required|exists:brands,id',
            'nr' => 'nullable',
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

            'yearly_estimations' => 'nullable|array',
            'yearly_estimations.*.year' => 'nullable',
            'yearly_estimations.*.amount' => 'nullable',

            'months_comments' => 'nullable|array',
            'months_comments.*.months' => 'nullable',
            'months_comments.*.comment' => 'nullable',

            'estado' => 'sometimes|in:1,2',

        ], [
            'brand_id.required' => 'La marca es requerida',
            'brand_id.exists' => 'La marca seleccionada no es válida',
            'brand.required' => 'La marca es requerida',
            'documents.*.file' => 'Cada documento debe ser un archivo válido',
            'documents.*.mimes' => 'Cada documento debe ser un archivo de tipo pdf, doc, docx, xls, xlsx, ppt, pptx, jpg, jpeg, png, svg',
            'yearly_estimations.*.year.unique' => 'Ya existe una estimación anual para el año ingresado',
            'months_comments.*.months.unique' => 'Ya existe un comentario para el mes ingresado',
            'estado.in' => 'El estado debe ser 1 (Inactivo) o 2 (Activo).',
        ]);
    }
}

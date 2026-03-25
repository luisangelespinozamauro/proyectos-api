<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Document;
use App\Models\DocumentVersion;

class DocumentSeeder extends Seeder
{
    public function run(): void
    {
        $doc = Document::create([
            'project_id' => 1,
            'type' => 'NDA',
            'name' => 'NDA Toyota',
            'current_version' => 2
        ]);

        DocumentVersion::create([
            'document_id' => $doc->id,
            'file_path' => 'documents/nda_v1.pdf',
            'version' => 1
        ]);

        DocumentVersion::create([
            'document_id' => $doc->id,
            'file_path' => 'documents/nda_v2.pdf',
            'version' => 2
        ]);
    }
}

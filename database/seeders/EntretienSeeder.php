<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Entretien;

class EntretienSeeder extends Seeder
{
    public function run(): void
    {
        Entretien::create([
            'candidature_id'    => 2,
            'type'              => 'phone',
            'scheduled_at'      => '2026-05-10 10:00:00',
            'preparation_notes' => 'Préparer questions sur Laravel',
            'result'            => 'passed',
        ]);

        Entretien::create([
            'candidature_id'    => 2,
            'type'              => 'technical',
            'scheduled_at'      => '2026-05-15 14:00:00',
            'preparation_notes' => 'Réviser algorithmes et structures de données',
            'result'            => 'pending',
        ]);

        Entretien::create([
            'candidature_id'    => 3,
            'type'              => 'hr',
            'scheduled_at'      => '2026-05-12 09:00:00',
            'preparation_notes' => 'Préparer questions sur le salaire',
            'result'            => 'passed',
        ]);
    }
}
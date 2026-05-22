<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Candidature;

class CandidatureSeeder extends Seeder
{
    public function run(): void
    {
        // 5 candidatures for user 1
        Candidature::create([
            'user_id'     => 1,
            'company'     => 'Google',
            'position'    => 'Développeur Laravel',
            'offer_url'   => 'https://google.com/jobs',
            'status'      => 'sent',
            'priority'    => 'high',
            'notes'       => 'Très bonne opportunité',
            'applied_at'  => '2026-05-01',
        ]);

        Candidature::create([
            'user_id'     => 1,
            'company'     => 'Microsoft',
            'position'    => 'Ingénieur Backend',
            'offer_url'   => 'https://microsoft.com/jobs',
            'status'      => 'interview',
            'priority'    => 'high',
            'notes'       => 'Entretien prévu',
            'applied_at'  => '2026-05-03',
        ]);

        Candidature::create([
            'user_id'     => 1,
            'company'     => 'Amazon',
            'position'    => 'Développeur Full Stack',
            'offer_url'   => null,
            'status'      => 'offer',
            'priority'    => 'medium',
            'notes'       => 'Offre reçue en attente de décision',
            'applied_at'  => '2026-04-20',
        ]);

        Candidature::create([
            'user_id'     => 1,
            'company'     => 'Meta',
            'position'    => 'Développeur PHP',
            'offer_url'   => 'https://meta.com/jobs',
            'status'      => 'rejected',
            'priority'    => 'low',
            'notes'       => null,
            'applied_at'  => '2026-04-15',
        ]);

        Candidature::create([
            'user_id'     => 1,
            'company'     => 'Apple',
            'position'    => 'Ingénieur Logiciel',
            'offer_url'   => 'https://apple.com/jobs',
            'status'      => 'withdrawn',
            'priority'    => 'medium',
            'notes'       => 'Poste retiré',
            'applied_at'  => '2026-04-10',
        ]);

        // 2 candidatures for user 2
        Candidature::create([
            'user_id'     => 2,
            'company'     => 'Netflix',
            'position'    => 'Développeur Backend',
            'offer_url'   => null,
            'status'      => 'sent',
            'priority'    => 'medium',
            'notes'       => null,
            'applied_at'  => '2026-05-05',
        ]);

        Candidature::create([
            'user_id'     => 2,
            'company'     => 'Spotify',
            'position'    => 'Ingénieur PHP',
            'offer_url'   => 'https://spotify.com/jobs',
            'status'      => 'interview',
            'priority'    => 'high',
            'notes'       => 'Bon feeling',
            'applied_at'  => '2026-05-08',
        ]);
    }
}
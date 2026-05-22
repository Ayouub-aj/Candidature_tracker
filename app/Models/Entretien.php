<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Entretien extends Model
{
    protected $fillable = [
        'candidature_id',
        'type',
        'scheduled_at',
        'preparation_notes',
        'result',
    ];

    // Relationship
    public function candidature(): BelongsTo
    {
        return $this->belongsTo(Candidature::class);
    }

    // Accessors
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'phone'     => 'Téléphonique',
            'video'     => 'Visioconférence',
            'onsite'    => 'Présentiel',
            'technical' => 'Technique',
            'hr'        => 'RH',
            default     => $this->type,
        };
    }

    public function getResultLabelAttribute(): string
    {
        return match($this->result) {
            'pending' => 'En attente',
            'passed'  => 'Réussi',
            'failed'  => 'Échoué',
            default   => $this->result,
        };
    }
}
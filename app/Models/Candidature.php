<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Candidature extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'company',
        'position',
        'offer_url',
        'status',
        'priority',
        'notes',
        'applied_at',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entretiens(): HasMany
    {
        return $this->hasMany(Entretien::class);
    }

    // Accessors
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'sent'      => 'Envoyée',
            'interview' => 'Entretien',
            'offer'     => 'Offre reçue',
            'rejected'  => 'Refusée',
            'withdrawn' => 'Retirée',
            default     => $this->status,
        };
    }

    public function getPriorityLabelAttribute(): string
    {
        return match($this->priority) {
            'low'    => 'Basse',
            'medium' => 'Moyenne',
            'high'   => 'Haute',
            default  => $this->priority,
        };
    }
}
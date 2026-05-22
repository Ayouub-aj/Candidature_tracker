<?php

namespace App\Policies;

use App\Models\Candidature;
use App\Models\User;

class CandidaturePolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Candidature $candidature): bool
    {
        return $candidature->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Candidature $candidature): bool
    {
        return $candidature->user_id === $user->id;
    }

    public function delete(User $user, Candidature $candidature): bool
    {
        return $candidature->user_id === $user->id;
    }

    public function restore(User $user, Candidature $candidature): bool
    {
        return $candidature->user_id === $user->id;
    }

    public function forceDelete(User $user, Candidature $candidature): bool
    {
        return $candidature->user_id === $user->id;
    }
}
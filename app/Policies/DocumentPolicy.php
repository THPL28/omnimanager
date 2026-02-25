<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Document;

class DocumentPolicy
{
    /**
     * Determine whether the user can view the document.
     */
    public function view(User $user, Document $document): bool
    {
        // Allow uploader
        if ($document->uploaded_by && $user->id === $document->uploaded_by) {
            return true;
        }

        // Admins can view everything
        if ($user->role === 'admin') {
            return true;
        }

        // Allow users that belong to the same grupo_economico
        if ($user->grupo_economico_id && $document->grupo_economico_id && $user->grupo_economico_id === $document->grupo_economico_id) {
            return true;
        }

        return false;
    }

    public function create(User $user): bool
    {
        // Allow admins or users linked to a group
        if (in_array($user->role, ['admin','manager','responsavel'])) {
            return true;
        }

        return (bool) $user->grupo_economico_id;
    }

    public function update(User $user, Document $document): bool
    {
        return $document->uploaded_by && $user->id === $document->uploaded_by;
    }

    public function delete(User $user, Document $document): bool
    {
        return $document->uploaded_by && $user->id === $document->uploaded_by;
    }
}

<?php

namespace App\Support;

final class Panel
{
    /**
     * Prefix a logical route name (e.g. "pets.index") with the current user's panel.
     */
    public static function routeName(string $name): string
    {
        $user = auth()->user();
        if (! $user) {
            return $name;
        }

        return $user->isAdmin() ? 'admin.'.$name : 'client.'.$name;
    }
}

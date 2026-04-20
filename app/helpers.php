<?php

use App\Support\Panel;

if (! function_exists('panel_route')) {
    /**
     * Generate a URL for a resource route on the active panel (admin.* or client.*).
     */
    function panel_route(string $name, mixed $parameters = [], bool $absolute = true): string
    {
        return route(Panel::routeName($name), $parameters, $absolute);
    }
}

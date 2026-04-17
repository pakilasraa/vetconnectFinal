<?php

namespace App\Http\Controllers\Concerns;

use App\Support\Panel;
use Illuminate\Http\RedirectResponse;

trait RedirectsToPanelRoute
{
    protected function panelRedirect(string $route, array $parameters = []): RedirectResponse
    {
        return redirect()->route(Panel::routeName($route), $parameters);
    }
}

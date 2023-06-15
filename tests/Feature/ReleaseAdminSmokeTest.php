<?php

use App\Models\Role;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;


it('can visit all release admin routes', function () {
    $routes = collect(Route::getRoutes()->getRoutesByMethod()['GET'])->filter(fn ($r) => str($r->uri)->startsWith('release-admin'))->map(fn ($r) => $r->getName())->toArray();

    actingAs(User::whereRelation('roles', 'role_id', Role::RELEASE_ADMIN)->first());
    foreach ($routes as $key => $route) {
        dump($route);
        get(route($route))->assertSuccessful();
    }
});

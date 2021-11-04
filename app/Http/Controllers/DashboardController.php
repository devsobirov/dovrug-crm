<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function handle()
    {
        $user = auth()->user();
        $role = $user->getMainRole();

        if ($role) {
            return redirect()->route($role);
        }
        return abort(403);
    }
}

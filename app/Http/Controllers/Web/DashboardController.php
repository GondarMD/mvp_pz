<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Spatie\Permission\Traits\HasRoles;

class DashboardController extends Controller
{
    use HasRoles;
    
    /**
     * Display the dashboard based on user roles.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        // Check if the user is authenticated
        if ($request->user()) {
            // Return the dashboard view for authenticated users
            if ($request->user()->hasRole('admin')) {
                return Inertia::render('Dashboard/Admin', [
                    'user' => $request->user(),
                ]);
            } elseif ($request->user()->hasRole('authenticated')) {
                return Inertia::render('Dashboard/Authenticated', [
                    'user' => $request->user(),
                ]);
            } 
        }

        // Redirect to login if not authenticated
        return Inertia::render('Dashboard/Guest', [
            'canLogin' => route('login'),
            'status' => session('status'),
        ]);
    }
}

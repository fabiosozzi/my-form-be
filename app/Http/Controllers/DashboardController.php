<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ContactResource;

class DashboardController extends Controller
{
    public function index(Request $request): \Inertia\Response
    {
        // Check if the user has the permission to update and delete contacts
        $canUpdate = Auth::user()->can('edit contacts');
        $canDelete = Auth::user()->can('delete contacts');

        return Inertia::render('Dashboard', 
            [
                'contacts' => Inertia::lazy(function(Request $request) {
                    // Get all contacts paginated
                    $default_sort = 'created_at';
                    $default_order = 'desc';
                    if ($request->has('sort') && $request->has('order'))
                    {
                        $default_sort = $request->sort;
                        $default_order = $request->order;
                    }
                    $contacts = Contact::orderBy($default_sort, $default_order)->paginate(10)->withQueryString();
                    return ContactResource::collection($contacts);
                }),
                'canUpdate' => $canUpdate,
                'canDelete' => $canDelete,
                'sort_field' => $request->has('sort') ? $request->sort : 'created_at',
                'sort_order' => $request->has('order') ? $request->order : 'desc',
            ]
        );
    }
}

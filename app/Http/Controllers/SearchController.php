<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $user = auth()->user();

        if (empty($query)) {
            return view('search.results', [
                'pets' => collect([]),
                'owners' => collect([]),
                'query' => $query
            ]);
        }

        // Search Pets
        $petQuery = Pet::with('owner')->where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('species', 'like', "%{$query}%")
              ->orWhere('breed', 'like', "%{$query}%");
        });

        // Search Owners (Users with role 'owner')
        $ownerQuery = User::where('role', 'owner')->where(function($q) use ($query) {
            $q->where('name', 'like', "%{$query}%")
              ->orWhere('email', 'like', "%{$query}%");
        });

        // Apply role-based filtering
        if ($user->role === 'owner') {
            // Owners can only see their own pets and themselves
            $petQuery->where('owner_id', $user->id);
            $ownerQuery->where('id', $user->id);
        }

        $pets = $petQuery->get();
        $owners = $ownerQuery->get();

        return view('search.results', compact('pets', 'owners', 'query'));
    }
}

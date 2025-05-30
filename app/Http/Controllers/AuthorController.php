<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $page = $request->input('page', 1);
        $perPage = 20; // Nombre d'auteurs par page

        $query = Author::query();

        // Appliquer la recherche si nécessaire
        if (!empty($search)) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Récupérer les auteurs avec pagination
        $authors = $query->orderBy('name')
                        ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'authors' => $authors->items(),
            'more' => $authors->hasMorePages()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // TODO: Some validation here
        
        $author = new Author;
        $author->name = $request->first_name . ' ' . $request->last_name;
        $author->save();

        // Response 201 Created
        return response()->json($author, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Author $author)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Author $author)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Author $author)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Author $author)
    {
        //
    }
}

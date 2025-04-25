<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBookRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function fetchAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function fetchAllBooks()
    {
        $books = Book::all();
        return response()->json($books);
    }
    public function fetchUserBooks()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        $books = User::findOrFail($id)->books;
        $data = ["user" => $user, 'books' => $books];
        return response()->json($data);
    }

    public function createNewBook(NewBookRequest $request)
    {

        return response()->json(['requete recue'=>$request->validated()]);
        // // Récupérer les données validées
        // $validated = $request->validated();

        // // Traiter l'image de couverture si présente
        // if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
        //     $path = $request->file('cover_image')->store('images', 'public');
        //     $validated['cover_image'] = $path;
        // }

        // // S'assurer que l'utilisateur est bien authentifié
        // if (!Auth::check()) {
        //     return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        // }

        // // Ajouter l'ID de l'utilisateur connecté de façon explicite
        // $validated['user_id'] = Auth::user()->id;

        // try {
        //     // Créer le livre dans la base de données
        //     $newBook = Book::create([$request->validated(), 'user_id' => Auth::user()->id]);

        //     // Retourner une réponse avec le livre créé
        //     return response()->json($newBook, 201);
        // } catch (\Exception $e) {
        //     // Log l'erreur pour le débogage
        //     Log::error('Erreur lors de la création du livre: ' . $e->getMessage());

        //     return response()->json([
        //         'error' => 'Impossible de créer le livre',
        //         'details' => config('app.debug') ? $e->getMessage() : null
        //     ], 500);
        // }
    }
    /**
     * Méthode de debug pour voir ce que contient la requête
     * À utiliser temporairement en cas de problème
     */
    public function debugRequest(NewBookRequest $request)
    {
        return response()->json([
            'all' => $request->all(),
            'files' => $request->allFiles(),
            'headers' => $request->header(),
            'validated' => $request->validated(),
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBookRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        // S'assurer que l'utilisateur est bien authentifié
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        try {
            // Créer le livre dans la base de données
            $validatedData = $request->validated();
            $validatedData['user_id'] = Auth::user()->id;
            $newBook = Book::create($validatedData);
            // Retourner une réponse avec le livre créé
            return response()->json($newBook, 201);
        } catch (\Exception $e) {
            return response()->json([
                'ERREUR' => $e->getMessage(),
                'RECEIVED REQUEST' => $request->validated()
            ], 500);
        }
    }

    public function updateBook(NewBookRequest $request, $id)
{
    // S'assurer que l'utilisateur est bien authentifié
    if (!Auth::check()) {
        return response()->json(['error' => 'Utilisateur non authentifié'], 401);
    }

    try {
        $book = Book::findOrFail($id);
        
        if ($book->user_id != Auth::id()) {
            return response()->json(['error' => 'Non autorisé'], 403);
        }
        
        $validatedData = $request->validated();
        
        $oldBook = $book->toArray();
        
        $book->fill($request->only(array_keys($validatedData)));
        
        // Sauvegarder les modifications
        $book->save();
        
        // Retourner une réponse avec l'ancien et le nouveau livre
        return response()->json([
            'OLD' => $oldBook,
            'NEW' => $book
        ], 200); // 200 OK pour une mise à jour, pas 201
        
    } catch (\Exception $e) {
        return response()->json([
            'ERREUR' => $e->getMessage(),
            'RECEIVED REQUEST' => $request->validated()
        ], 500);
    }
}

    public function fetchBookById($id)
    {
        return response()->json(Book::findOrFail($id));
    }

    public function deleteBookById($id)
    {
        $book = Book::findOrFail($id);

        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        try {
            if ($book->user_id === Auth::user()->id) {
                $book->delete();
                return response()->noContent();
            } else {
                return response()->json(['error' => 'Non autorisé'], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'ERREUR' => $e->getMessage()
            ], 500);
        }
    }
}

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

    public function fetchBookById($id)
    {
        return response()->json(Book::findOrFail($id));
    }

    public function deleteBookById($id)
    {
        $book = Book::findOrFail($id);


        try {
            if (Auth::check() && $book->user_id === Auth::user()->id) {
                $book->delete();
                return response()->noContent();
            } else {
                return response()->json(['error' => "Vous n'avez pas les droits sur cette collection"]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'ERREUR' => $e->getMessage()
            ], 500);
        }
    }
}

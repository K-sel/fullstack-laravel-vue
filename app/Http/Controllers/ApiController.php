<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewBookRequest;
use App\Http\Requests\ProfileRequest;
use App\Models\Book;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function updateUserProfile(ProfileRequest $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $user = User::findOrFail(Auth::user()->id);
        $user->update($request->validated());
        return response()->json($user, 200);
    }

    public function deleteUser()
    {
        // S'assurer que l'utilisateur est bien authentifié
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        // Supprimer les livres associés à l'utilisateur avant de le supprimer
        try {
            Book::where('user_id', Auth::user()->id)->delete();
            $user = User::findOrFail(Auth::user()->id);
            $user->delete();
            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erreur lors de la suppression', 'message' => $e->getMessage()], 500);
        }
    }

    public function fetchAllUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function fetchUser()
    {
        $id = Auth::user()->id;
        $user = User::findOrFail($id);
        return response()->json($user);
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

    public function fetchPicture($id)
    {
        $book = Book::findOrFail($id);
        $image = $book->cover_image;
        $imageName = $book->cover_image_name ?: 'image.png';

        // Déterminer le type MIME en fonction de l'extension du fichier
        $extension = pathinfo($imageName, PATHINFO_EXTENSION);
        $mimeType = $this->getMimeTypeFromExtension($extension);

        return response($image)
            ->header('Content-Type', $mimeType)
            ->header('Content-Disposition', 'inline; filename="' . $imageName . '"');
    }

    // Fonction auxiliaire pour déterminer le type MIME
    private function getMimeTypeFromExtension($extension)
    {
        $mimeTypes = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            // Ajoutez d'autres types selon vos besoins
        ];

        return $mimeTypes[strtolower($extension)] ?? 'application/octet-stream';
    }



    public function createNewBook(NewBookRequest $request)
    {
        // S'assurer que l'utilisateur est bien authentifié
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }

        $validatedData = $request->validated();
        $url = $validatedData['cover_image_path'];

        // Récupérer le contenu de l'image
        try {
            $imageContent = file_get_contents($url);
        } catch (\Exception $e) {
            $imageContent = file_get_contents(public_path('images/no-image.jpg'));
        }

        try {
            // Extraire le nom de l'image depuis l'URL
            $imageName = basename(parse_url($url, PHP_URL_PATH));

            // Mettre à jour les données validées - stockage en binaire brut
            $validatedData['cover_image'] = $imageContent;
            $validatedData['cover_image_name'] = $imageName ?: 'image.png';
            $validatedData['cover_image_path'] = $url;
            $validatedData['user_id'] = Auth::user()->id;

            // Créer le livre
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
            $url = $validatedData['cover_image_path'];
            // Récupérer le contenu de l'image
            try {
                $imageContent = file_get_contents($url);
            } catch (\Exception $e) {
                $imageContent = file_get_contents(public_path('images/no-image.jpg'));
            }
            // Extraire le nom de l'image depuis l'URL
            $imageName = basename(parse_url($url, PHP_URL_PATH));
            // Mettre à jour les données validées - stockage en binaire brut
            $validatedData['cover_image'] = $imageContent;
            $validatedData['cover_image_path'] = $url;
            $validatedData['cover_image_name'] = $imageName ?: 'image.png';

            $oldBook = $book->toArray();

            $book->fill($validatedData);

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
        if (!Auth::check()) {
            return response()->json(['error' => 'Utilisateur non authentifié'], 401);
        }
        $book = Book::findOrFail($id);

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

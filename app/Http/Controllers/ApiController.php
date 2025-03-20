<?php

namespace App\Http\Controllers;

use App\Models\Sauce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    /**
     * Afficher la liste des sauces
     */
    public function index()
    {
        $sauces = Sauce::all();
        return response()->json($sauces, 200);
    }

    /**
     * Stocker une nouvelle sauce
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'description' => 'required|string',
            'main_pepper' => 'required|string|max:255',
            'heat' => 'required|integer|min:1|max:10',
        ]);

        $sauce = new Sauce();
        $sauce->user_id = Auth::id();
        $sauce->name = $validated['name'];
        $sauce->manufacturer = $validated['manufacturer'];
        $sauce->description = $validated['description'];
        $sauce->main_pepper = $validated['main_pepper'];
        $sauce->heat = $validated['heat'];
        
        // Gérer l'upload d'image si présent
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sauces', 'public');
            $sauce->image_url = '/storage/' . $imagePath;
        }
        
        // Initialiser les likes et dislikes
        $sauce->likes = 0;
        $sauce->dislikes = 0;
        $sauce->users_liked = json_encode([]);
        $sauce->users_disliked = json_encode([]);
        
        $sauce->save();
        
        return response()->json($sauce, 201);
    }

    /**
     * Afficher une sauce spécifique
     */
    public function show($id)
    {
        $sauce = Sauce::find($id);
        
        if (!$sauce) {
            return response()->json(['message' => 'Sauce non trouvée'], 404);
        }
        
        return response()->json($sauce, 200);
    }

    /**
     * Mettre à jour une sauce
     */
    public function update(Request $request, $id)
    {
        $sauce = Sauce::find($id);
        
        if (!$sauce) {
            return response()->json(['message' => 'Sauce non trouvée'], 404);
        }
        
        // Vérifier que l'utilisateur est le propriétaire de la sauce
        if ($sauce->user_id != Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'description' => 'required|string',
            'main_pepper' => 'required|string|max:255',
            'heat' => 'required|integer|min:1|max:10',
        ]);
        
        $sauce->name = $validated['name'];
        $sauce->manufacturer = $validated['manufacturer'];
        $sauce->description = $validated['description'];
        $sauce->main_pepper = $validated['main_pepper'];
        $sauce->heat = $validated['heat'];
        
        // Gérer l'upload d'image si présent
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sauces', 'public');
            $sauce->image_url = '/storage/' . $imagePath;
        }
        
        $sauce->save();
        
        return response()->json($sauce, 200);
    }

    /**
     * Supprimer une sauce
     */
    public function destroy($id)
    {
        $sauce = Sauce::find($id);
        
        if (!$sauce) {
            return response()->json(['message' => 'Sauce non trouvée'], 404);
        }
        
        // Vérifier que l'utilisateur est le propriétaire de la sauce
        if ($sauce->user_id != Auth::id()) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
        
        $sauce->delete();
        
        return response()->json(['message' => 'Sauce supprimée avec succès'], 200);
    }

    /**
     * Liker ou disliker une sauce
     */
    public function like(Request $request, $id)
    {
        $sauce = Sauce::find($id);
        
        if (!$sauce) {
            return response()->json(['message' => 'Sauce non trouvée'], 404);
        }
        
        $validated = $request->validate([
            'like' => 'required|in:1,-1,0',
        ]);
        
        $userId = Auth::id();
        $like = $request->input('like');
        
        // Convertir les tableaux JSON en tableaux PHP
        $usersLiked = json_decode($sauce->users_liked, true) ?: [];
        $usersDisliked = json_decode($sauce->users_disliked, true) ?: [];
        
        // Retirer l'utilisateur des deux tableaux
        $usersLiked = array_diff($usersLiked, [$userId]);
        $usersDisliked = array_diff($usersDisliked, [$userId]);
        
        // Ajouter l'utilisateur au tableau approprié selon son choix
        if ($like == 1) {
            $usersLiked[] = $userId;
        } else if ($like == -1) {
            $usersDisliked[] = $userId;
        }
        
        // Mettre à jour les tableaux et compteurs
        $sauce->users_liked = json_encode(array_values($usersLiked));
        $sauce->users_disliked = json_encode(array_values($usersDisliked));
        $sauce->likes = count($usersLiked);
        $sauce->dislikes = count($usersDisliked);
        
        $sauce->save();
        
        return response()->json(['message' => 'Préférence enregistrée'], 200);
    }
}
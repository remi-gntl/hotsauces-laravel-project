<?php

namespace App\Http\Controllers;

use App\Models\Sauce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SauceController extends Controller
{
    public function index()
    {
        $sauces = Sauce::all();
        return view('sauces.index', compact('sauces'));
    }

    public function create()
    {
        return view('sauces.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'manufacturer' => 'required|string|max:255',
            'description' => 'required|string',
            'main_pepper' => 'required|string|max:255',
            'image_url' => 'nullable|url',
            'heat' => 'required|integer|min:1|max:10',
        ]);

        $sauce = new Sauce($validated);
        $sauce->user_id = Auth::id();
        $sauce->save();

        return redirect()->route('sauces.index')
            ->with('success', 'Sauce ajoutée avec succès!');
    }

    public function show(Sauce $sauce)
    {
        return view('sauces.show', compact('sauce'));
    }

    public function edit(Sauce $sauce)
    {
        // Vérifier que l'utilisateur est le propriétaire de la sauce
        if ($sauce->user_id !== Auth::id()) {
            return redirect()->route('sauces.index')
                ->with('error', 'Vous n\'êtes pas autorisé à modifier cette sauce.');
        }

        return view('sauces.edit', compact('sauce'));
    }

    public function update(Request $request, Sauce $sauce)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'image_url' => 'nullable|url',
            'heat' => 'required|integer|min:1|max:10',
        ]);

        $sauce->update($validated);

        return redirect()->route('sauces.index')->with('success', 'Sauce mise à jour avec succès!');
    }

    public function destroy(Sauce $sauce)
    {
        // Vérifier que l'utilisateur est le propriétaire de la sauce
        if ($sauce->user_id !== Auth::id()) {
            return redirect()->route('sauces.index')
                ->with('error', 'Vous n\'êtes pas autorisé à supprimer cette sauce.');
        }

        $sauce->delete();

        return redirect()->route('sauces.index')
            ->with('success', 'Sauce supprimée avec succès!');
    }

    public function like(Sauce $sauce)
    {
        $userId = Auth::id();
        $usersLiked = $sauce->users_liked ?? [];
        $usersDisliked = $sauce->users_disliked ?? [];

        // Si l'utilisateur a déjà liké, on annule son like
        if (in_array($userId, $usersLiked)) {
            $sauce->users_liked = array_diff($usersLiked, [$userId]);
            $sauce->likes = max(0, $sauce->likes - 1);
        } else {
            // Si l'utilisateur avait disliké, on retire son dislike
            if (in_array($userId, $usersDisliked)) {
                $sauce->users_disliked = array_diff($usersDisliked, [$userId]);
                $sauce->dislikes = max(0, $sauce->dislikes - 1);
            }
            // On ajoute le like
            $sauce->users_liked = array_merge($usersLiked, [$userId]);
            $sauce->likes += 1;
        }

        $sauce->save();

        return redirect()->back();
    }

    public function dislike(Sauce $sauce)
    {
        $userId = Auth::id();
        $usersLiked = $sauce->users_liked ?? [];
        $usersDisliked = $sauce->users_disliked ?? [];

        // Si l'utilisateur a déjà disliké, on annule son dislike
        if (in_array($userId, $usersDisliked)) {
            $sauce->users_disliked = array_diff($usersDisliked, [$userId]);
            $sauce->dislikes = max(0, $sauce->dislikes - 1);
        } else {
            // Si l'utilisateur avait liké, on retire son like
            if (in_array($userId, $usersLiked)) {
                $sauce->users_liked = array_diff($usersLiked, [$userId]);
                $sauce->likes = max(0, $sauce->likes - 1);
            }
            // On ajoute le dislike
            $sauce->users_disliked = array_merge($usersDisliked, [$userId]);
            $sauce->dislikes += 1;
        }

        $sauce->save();

        return redirect()->back();
    }
}

@extends('layouts.app')

@section('title', 'Liste des sauces')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Liste des sauces</h1>
        <a href="{{ route('sauces.create') }}" class="btn btn-primary">Ajouter une sauce</a>
    </div>

    <div class="row">
        @forelse($sauces as $sauce)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    @if($sauce->image_url)
                        <img src="{{ $sauce->image_url }}" class="card-img-top" alt="{{ $sauce->name }}">
                    @else
                        <div class="card-img-top bg-light text-center p-5">Pas d'image</div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $sauce->name }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $sauce->manufacturer }}</h6>
                        <p class="card-text">{{ Str::limit($sauce->description, 100) }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-danger">Niveau {{ $sauce->heat }}/10</span>
                            </div>
                            <a href="{{ route('sauces.show', $sauce) }}" class="btn btn-sm btn-outline-primary">Voir détails</a>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <div class="d-flex justify-content-between">
                            <div>
                                <form action="{{ route('sauces.like', $sauce) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ in_array(Auth::id(), $sauce->users_liked ?? []) ? 'btn-success' : 'btn-outline-success' }}">
                                        👍 {{ $sauce->likes }}
                                    </button>
                                </form>
                                <form action="{{ route('sauces.dislike', $sauce) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ in_array(Auth::id(), $sauce->users_disliked ?? []) ? 'btn-danger' : 'btn-outline-danger' }}">
                                        👎 {{ $sauce->dislikes }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Aucune sauce disponible pour le moment.</div>
            </div>
        @endforelse
    </div>
@endsection
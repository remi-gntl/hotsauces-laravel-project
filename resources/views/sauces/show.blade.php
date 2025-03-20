@extends('layouts.app')

@section('title', $sauce->name)

@section('content')
    <div class="mb-4">
        <a href="{{ route('sauces.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2>{{ $sauce->name }}</h2>
            @if(Auth::id() === $sauce->user_id)
                <div>
                    <a href="{{ route('sauces.edit', $sauce) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('sauces.destroy', $sauce) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette sauce?')">Supprimer</button>
                    </form>
                </div>
            @endif
        </div>
        <div class="card-body">
            @if($sauce->image_url)
                <div class="text-center mb-4">
                    <img src="{{ $sauce->image_url }}" alt="{{ $sauce->name }}" class="img-fluid" style="max-height: 300px;">
                </div>
            @endif
            
            <div class="row mb-3">
                <div class="col-md-6">
                    <h4>Fabricant</h4>
                    <p>{{ $sauce->manufacturer }}</p>
                </div>
                <div class="col-md-6">
                    <h4>Ingrédient principal épicé</h4>
                    <p>{{ $sauce->main_pepper }}</p>
                </div>
            </div>
            
            <div class="mb-3">
                <h4>Description</h4>
                <p>{{ $sauce->description }}</p>
            </div>
            
            <div class="mb-3">
                <h4>Niveau de piquant</h4>
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $sauce->heat * 10 }}%;" aria-valuenow="{{ $sauce->heat }}" aria-valuemin="0" aria-valuemax="10">{{ $sauce->heat }}/10</div>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <div>
                    <form action="{{ route('sauces.like', $sauce) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ in_array(Auth::id(), $sauce->users_liked ?? []) ? 'btn-success' : 'btn-outline-success' }}">
                            <i class="bi bi-hand-thumbs-up"></i> {{ $sauce->likes ?? 0 }}
                        </button>
                    </form>
                </div>
                <div>
                    <form action="{{ route('sauces.dislike', $sauce) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn {{ in_array(Auth::id(), $sauce->users_disliked ?? []) ? 'btn-danger' : 'btn-outline-danger' }}">
                            <i class="bi bi-hand-thumbs-down"></i> {{ $sauce->dislikes ?? 0 }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
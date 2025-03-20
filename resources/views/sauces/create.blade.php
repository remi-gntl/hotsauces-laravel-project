@extends('layouts.app')

@section('title', 'Ajouter une sauce')

@section('content')
    <div class="mb-4">
        <a href="{{ route('sauces.index') }}" class="btn btn-secondary">Retour à la liste</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Ajouter une nouvelle sauce</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('sauces.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="manufacturer" class="form-label">Fabricant</label>
                    <input type="text" class="form-control @error('manufacturer') is-invalid @enderror" id="manufacturer" name="manufacturer" value="{{ old('manufacturer') }}" required>
                    @error('manufacturer')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="main_pepper" class="form-label">Ingrédient principal épicé</label>
                    <input type="text" class="form-control @error('main_pepper') is-invalid @enderror" id="main_pepper" name="main_pepper" value="{{ old('main_pepper') }}" required>
                    @error('main_pepper')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="image_url" class="form-label">URL de l'image</label>
                    <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url') }}">
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="heat" class="form-label">Niveau de piquant (1-10)</label>
                    <input type="range" class="form-range" id="heat" name="heat" min="1" max="10" value="{{ old('heat', 5) }}">
                    <div class="d-flex justify-content-between">
                        <span>1</span>
                        <span>2</span>
                        <span>3</span>
                        <span>4</span>
                        <span>5</span>
                        <span>6</span>
                        <span>7</span>
                        <span>8</span>
                        <span>9</span>
                        <span>10</span>
                    </div>
                    @error('heat')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <button type="submit" class="btn btn-primary">Ajouter la sauce</button>
            </form>
        </div>
    </div>
@endsection
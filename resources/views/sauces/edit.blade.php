@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <h1>Modifier la sauce</h1>
            
            <form action="{{ route('sauces.update', $sauce->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Nom de la sauce</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $sauce->name) }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description">{{ old('description', $sauce->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="image_url" class="form-label">URL de l'image</label>
                    <input type="url" class="form-control @error('image_url') is-invalid @enderror" id="image_url" name="image_url" value="{{ old('image_url', $sauce->image_url) }}">
                    @error('image_url')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-3">
                    <label for="heat" class="form-label">Niveau de piquant (1-10)</label>
                    <input type="range" class="form-range" id="heat" name="heat" min="1" max="10" value="{{ old('heat', $sauce->heat) }}">
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
                
                <button type="submit" class="btn btn-primary">Mettre à jour la sauce</button>
            </form>
        </div>
    </div>
@endsection
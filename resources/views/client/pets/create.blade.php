@extends('layouts.client-app')

@section('title', 'Add Pet - VetConnect')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Pet</h1>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ panel_route('pets.store') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Pet Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" placeholder="Enter pet name" required>
            @error('name') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="species" class="form-label">Species *</label>
                <input type="text" id="species" name="species" value="{{ old('species') }}" class="form-input" placeholder="e.g. Dog, Cat" required>
                @error('species') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="breed" class="form-label">Breed</label>
                <input type="text" id="breed" name="breed" value="{{ old('breed') }}" class="form-input" placeholder="e.g. Golden Retriever">
                @error('breed') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label for="gender" class="form-label">Gender</label>
                <select id="gender" name="gender" class="form-input">
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="form-group">
                <label for="weight" class="form-label">Weight (kg)</label>
                <input type="number" step="0.01" id="weight" name="weight" value="{{ old('weight') }}" class="form-input" placeholder="0.00">
                @error('weight') <p class="text-error mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="birth_date" class="form-label">Birth Date</label>
            <input type="date" id="birth_date" name="birth_date" value="{{ old('birth_date') }}" class="form-input">
            @error('birth_date') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label for="medical_history" class="form-label">Medical History</label>
            <textarea id="medical_history" name="medical_history" rows="3" class="form-input" placeholder="Any previous conditions, allergies, etc...">{{ old('medical_history') }}</textarea>
            @error('medical_history') <p class="text-error mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="form-actions">
            <a href="{{ panel_route('pets.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Add Pet</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Add Pet - VetConnect')

@section('content')
<div class="page-header">
    <h1 class="page-title">Add New Pet</h1>
</div>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <form action="{{ route('pets.store') }}" method="POST" class="form">
        @csrf

        <div class="form-group">
            <label for="name" class="form-label">Pet Name *</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-input" required>
        </div>

        <div class="form-group">
            <label for="species" class="form-label">Species *</label>
            <select id="species" name="species" class="form-input" required>
                <option value="">Select species</option>
                <option value="Dog" {{ old('species') == 'Dog' ? 'selected' : '' }}>Dog</option>
                <option value="Cat" {{ old('species') == 'Cat' ? 'selected' : '' }}>Cat</option>
                <option value="Bird" {{ old('species') == 'Bird' ? 'selected' : '' }}>Bird</option>
                <option value="Rabbit" {{ old('species') == 'Rabbit' ? 'selected' : '' }}>Rabbit</option>
                <option value="Other" {{ old('species') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
        </div>

        <div class="form-group">
            <label for="breed" class="form-label">Breed *</label>
            <input type="text" id="breed" name="breed" value="{{ old('breed') }}" class="form-input" required>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="age" class="form-label">Age</label>
                <input type="text" id="age" name="age" value="{{ old('age') }}" class="form-input" placeholder="e.g., 3 years">
            </div>

            <div class="form-group">
                <label for="weight" class="form-label">Weight</label>
                <input type="text" id="weight" name="weight" value="{{ old('weight') }}" class="form-input" placeholder="e.g., 32 kg">
            </div>
        </div>

        <div class="form-group">
            <label for="color" class="form-label">Color</label>
            <input type="text" id="color" name="color" value="{{ old('color') }}" class="form-input">
        </div>

        <div class="form-group">
            <label for="gender" class="form-label">Gender</label>
            <select id="gender" name="gender" class="form-input">
                <option value="">Select gender</option>
                <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="microchip" class="form-label">Microchip Number</label>
            <input type="text" id="microchip" name="microchip" value="{{ old('microchip') }}" class="form-input">
        </div>

        <div class="form-actions">
            <a href="{{ route('pets.index') }}" class="btn btn-outline">Cancel</a>
            <button type="submit" class="btn btn-primary">Add Pet</button>
        </div>
    </form>
</div>
@endsection

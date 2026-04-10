@extends('layouts.valex')
@section('page-title', 'Create Pet Record')
@section('breadcrumb-parent', 'Pet Management')
@section('breadcrumb-child', 'Create')

@section('content')
    <div class="xl:col-span-12 col-span-12">

        <div class="box custom-box mt-3">
            <div class="box-header">
                <div class="box-title">Pet Details</div>
            </div>
            <form action="{{ route('pets.store') }}" method="POST">
                @csrf
                <div class="box-body">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="xl:col-span-6 col-span-12">
                            <label for="owner_id" class="form-label">Owner</label>
                            <select name="owner_id" id="owner_id" class="form-control" required>
                                <option value="">Select Owner</option>
                                @foreach($owners as $owner)
                                    <option value="{{ $owner->id }}">{{ $owner->name }} ({{ $owner->email }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="xl:col-span-6 col-span-12">
                            <label for="name" class="form-label">Pet Name</label>
                            <input type="text" name="name" id="name" class="form-control" required placeholder="Enter pet name">
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="species" class="form-label">Species</label>
                            <input type="text" name="species" id="species" class="form-control" required placeholder="e.g. Dog, Cat">
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="breed" class="form-label">Breed</label>
                            <input type="text" name="breed" id="breed" class="form-control" placeholder="e.g. Golden Retriever">
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="gender" class="form-label">Gender</label>
                            <select name="gender" id="gender" class="form-control">
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="birth_date" class="form-label">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" class="form-control">
                        </div>
                        <div class="xl:col-span-4 col-span-12">
                            <label for="weight" class="form-label">Weight (kg)</label>
                            <input type="number" step="0.01" name="weight" id="weight" class="form-control" placeholder="0.00">
                        </div>
                        <div class="xl:col-span-12 col-span-12">
                            <label for="medical_history" class="form-label">Medical History</label>
                            <textarea name="medical_history" id="medical_history" class="form-control" rows="4" placeholder="Previous medical conditions, allergies, etc."></textarea>
                        </div>
                    </div>
                </div>
                <div class="box-footer text-end">
                    <a href="{{ route('pets.index') }}" class="ti-btn ti-btn-light">Cancel</a>
                    <button type="submit" class="ti-btn ti-btn-primary">Create Pet</button>
                </div>
            </form>
        </div>
    </div>
@endsection

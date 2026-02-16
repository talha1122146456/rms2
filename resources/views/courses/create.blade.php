@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Add New Course</h2>
        <a href="{{ route('courses.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">Course Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Enter course title" value="{{ old('title') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4" placeholder="Enter course description">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="instructor" class="form-label fw-semibold">Instructor</label>
            <input type="text" name="instructor" id="instructor" class="form-control" placeholder="Instructor name" value="{{ old('instructor') }}">
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label fw-semibold">Duration (hours)</label>
            <input type="number" name="duration" id="duration" class="form-control" placeholder="Enter duration" value="{{ old('duration') }}">
        </div>

        <div class="mb-3">
            <label for="image" class="form-label fw-semibold">Course Image</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*">
        </div>

        <div class="mb-4">
            <label for="files" class="form-label fw-semibold">Course Files (PDF / Videos)</label>
            <input type="file" name="files[]" id="files" class="form-control" multiple accept=".pdf,video/*">
            <small class="text-muted">You can upload multiple files.</small>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save"></i> Create Course
            </button>
        </div>
    </form>
</div>
@endsection

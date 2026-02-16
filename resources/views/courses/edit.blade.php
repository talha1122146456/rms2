@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">Edit Course</h2>
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

    <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data" class="p-4 border rounded shadow-sm bg-light">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="title" class="form-label fw-semibold">Course Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $course->title) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label fw-semibold">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $course->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="instructor" class="form-label fw-semibold">Instructor</label>
            <input type="text" name="instructor" id="instructor" class="form-control" value="{{ old('instructor', $course->instructor) }}">
        </div>

        <div class="mb-3">
            <label for="duration" class="form-label fw-semibold">Duration (hours)</label>
            <input type="number" name="duration" id="duration" class="form-control" value="{{ old('duration', $course->duration) }}">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Current Image</label><br>
            @if($course->image)
                <img src="{{ asset('storage/' . $course->image) }}" width="120" class="rounded shadow-sm mb-2" alt="Course Image">
            @else
                <p class="text-muted">No image uploaded</p>
            @endif
            <input type="file" name="image" class="form-control mt-2" accept="image/*">
        </div>

        <div class="mb-4">
            <label for="files" class="form-label fw-semibold">Upload New Files (Optional)</label>
            <input type="file" name="files[]" id="files" class="form-control" multiple accept=".pdf,video/*">
            <small class="text-muted">Leave empty if no new files.</small>
        </div>

        @if($course->files->count())
        <div class="mb-4">
            <h5 class="fw-semibold">Existing Files:</h5>
            <ul class="list-group">
                @foreach($course->files as $file)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <i class="fas fa-file me-2 text-secondary"></i>
                            {{ $file->file_name }}
                        </span>
                        <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="text-end">
            <button type="submit" class="btn btn-warning px-4">
                <i class="fas fa-save"></i> Update Course
            </button>
        </div>
    </form>
</div>
@endsection

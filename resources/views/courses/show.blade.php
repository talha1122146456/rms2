@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- 🔙 Back Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('courses.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back
        </a>
        <h2 class="fw-bold text-primary mb-0 text-center flex-grow-1">{{ $course->title }}</h2>
    </div>

    {{-- 🖼 Course Card --}}
    <div class="card shadow-sm mb-5 border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            {{-- Course Image --}}
            <div class="col-md-4 text-center bg-light p-3">
                @if ($course->image)
                    <img src="{{ asset('storage/' . $course->image) }}" 
                         class="img-fluid rounded-3 shadow-sm" 
                         alt="{{ $course->title }}">
                @else
                    <div class="d-flex align-items-center justify-content-center text-muted bg-white rounded-3 border p-5" style="height: 100%;">
                        <i class="fas fa-image me-2"></i> No Image Available
                    </div>
                @endif
            </div>

            {{-- Course Info --}}
            <div class="col-md-8">
                <div class="card-body p-4">
                    <h4 class="fw-bold text-dark mb-3">{{ $course->title }}</h4>
                    <p class="text-muted mb-3">{{ $course->description ?: 'No description available.' }}</p>
                    
                    <ul class="list-unstyled mb-4">
                        <li><strong><i class="fas fa-user-tie me-2 text-secondary"></i>Instructor:</strong> {{ $course->instructor ?? 'N/A' }}</li>
                        <li><strong><i class="fas fa-clock me-2 text-secondary"></i>Duration:</strong> {{ $course->duration ? $course->duration . ' hrs' : 'N/A' }}</li>
                        <li><strong><i class="fas fa-file-alt me-2 text-secondary"></i>Total Files:</strong> {{ $course->files->count() }}</li>
                    </ul>

                    {{-- 🎓 Enroll Button (only for non-admin users) --}}
                    @auth
                        @if(auth()->user()->role !== 'admin')
                            @if(!auth()->user()->enrolledCourses->contains($course->id))
                                <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-user-plus me-1"></i> Enroll in this Course
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info mt-3 mb-0">
                                    <i class="fas fa-check-circle me-2"></i>
                                    You are already enrolled in this course.
                                </div>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-1"></i> Log in to Enroll
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- 📚 Course Files Section --}}
    <div class="mt-5">
        <h4 class="fw-bold text-primary mb-4">
            <i class="fas fa-folder-open me-2"></i> Course Materials
        </h4>

        @if ($course->files->count())
            @foreach ($course->files as $file)
                <div class="card shadow-sm mb-4 border-0 rounded-3">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="fw-semibold mb-0">
                                <i class="fas fa-file me-2 text-secondary"></i> {{ $file->file_name }}
                            </h6>
                            <div>
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary me-1">
                                    <i class="fas fa-external-link-alt"></i> Open
                                </a>
                                <a href="{{ asset('storage/' . $file->file_path) }}" download class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-download"></i> Download
                                </a>
                            </div>
                        </div>

                        {{-- File Preview --}}
                        @if ($file->file_type === 'pdf')
                            <iframe src="{{ asset('storage/' . $file->file_path) }}" 
                                    class="w-100 rounded shadow-sm" 
                                    style="height: 500px; border: 1px solid #ddd;"></iframe>
                        @elseif(in_array($file->file_type, ['mp4', 'mov', 'avi']))
                            <video controls class="w-100 rounded shadow-sm" style="max-height: 400px;">
                                <source src="{{ asset('storage/' . $file->file_path) }}" type="video/{{ $file->file_type }}">
                                Your browser does not support the video tag.
                            </video>
                        @else
                            <p class="text-muted small fst-italic">
                                <i class="fas fa-info-circle me-1"></i> Preview not available for this file type.
                            </p>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="alert alert-warning text-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                No materials uploaded for this course yet.
            </div>
        @endif
    </div>

</div>
@endsection

@if ($courses->isEmpty())
    <div class="alert alert-info text-center my-5 py-4 rounded-3 shadow-sm">
        <i class="fas fa-info-circle fa-lg me-2"></i>
        You are not enrolled in any courses yet.
    </div>
@else
    <div class="row g-4">
        @foreach ($courses as $course)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card course-card h-100 shadow-sm border-0 rounded-4 overflow-hidden position-relative bg-white transition">

                    {{-- 🖼 Course Image --}}
                    <div class="position-relative">
                        @if ($course->image)
                            <img 
                                src="{{ asset('storage/' . $course->image) }}" 
                                class="card-img-top" 
                                alt="{{ $course->title }}" 
                                style="height: 220px; object-fit: cover;">
                        @else
                            <img 
                                src="https://via.placeholder.com/400x220?text=No+Image" 
                                class="card-img-top" 
                                alt="No Image" 
                                style="height: 220px; object-fit: cover;">
                        @endif

                        {{-- ✨ Hover Overlay --}}
                        <div class="overlay d-flex justify-content-center align-items-center">
                            <a href="{{ route('courses.show', $course->id) }}" 
                               class="btn btn-light btn-lg fw-semibold shadow-sm">
                                <i class="fas fa-eye me-1"></i> View Course
                            </a>
                        </div>
                    </div>

                    {{-- 📘 Course Info --}}
                    <div class="card-body">
                        <h5 class="card-title fw-bold text-primary mb-2">{{ $course->title }}</h5>

                        <p class="card-text mb-1 text-muted">
                            <i class="fas fa-user me-2 text-secondary"></i>
                            <strong>Instructor:</strong> {{ $course->instructor ?: 'N/A' }}
                        </p>

                        <p class="card-text mb-2 text-muted">
                            <i class="fas fa-clock me-2 text-secondary"></i>
                            <strong>Duration:</strong> {{ $course->duration ? $course->duration . ' hrs' : 'N/A' }}
                        </p>

                        <small class="text-muted d-block mt-2">
                            <i class="fas fa-calendar-alt me-1"></i>
                            Enrolled on: {{ optional($course->pivot->created_at)->format('Y-m-d') ?? 'N/A' }}
                        </small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- 🔁 Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {!! $courses->links('pagination::bootstrap-5') !!}
    </div>
@endif

{{-- 🎨 Styles for cards and overlay --}}
<style>
.course-card {
    transition: all 0.3s ease;
    border-radius: 12px;
}
.course-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
}

/* Overlay Styling */
.overlay {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(13, 110, 253, 0.75);
    opacity: 0;
    transition: opacity 0.4s ease;
}
.course-card:hover .overlay {
    opacity: 1;
}

/* Button inside overlay */
.overlay .btn {
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.25s ease;
}
.overlay .btn:hover {
    background-color: #0d6efd;
    color: #fff;
}
</style>

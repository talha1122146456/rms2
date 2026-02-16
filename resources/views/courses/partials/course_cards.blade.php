@if ($courses->isEmpty())
    <div class="alert alert-info text-center my-5 py-4 rounded-3 shadow-sm">
        <i class="fa fa-info-circle fa-lg me-2"></i>
        No courses found.
    </div>
@else
    <div class="row g-4">
        @foreach ($courses as $course)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100 shadow-sm border-0 rounded-3 overflow-hidden position-relative transition course-card">
                    
                    {{-- 🔹 Course Image --}}
                    @if ($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" 
                             class="card-img-top" 
                             alt="Course Image" 
                             style="height: 220px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/400x220?text=No+Image" 
                             class="card-img-top" 
                             alt="No Image" 
                             style="height: 220px; object-fit: cover;">
                    @endif

                    {{-- 🔹 Overlay (for students / login prompt) --}}
                    @if (!isset($hideOverlay) || !$hideOverlay)
                        <div class="overlay d-flex justify-content-center align-items-center">
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-light btn-lg px-4">
                                        <i class="fa fa-eye"></i> View
                                    </a>
                                @elseif (auth()->user()->enrolledCourses->contains($course->id))
                                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-success btn-lg px-4">
                                        <i class="fa fa-check"></i> Enrolled
                                    </a>
                                @else
                                    <form action="{{ route('courses.enroll', $course->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-lg px-4">
                                            <i class="fa fa-user-plus"></i> Enroll Now
                                        </button>
                                    </form>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-4">
                                    <i class="fa fa-sign-in-alt"></i> Login to Enroll
                                </a>
                            @endauth
                        </div>
                    @endif

                    {{-- 🔹 Card Body --}}
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary fw-bold">{{ $course->title }}</h5>
                        <p class="card-text mb-1"><strong>Instructor:</strong> {{ $course->instructor ?: 'N/A' }}</p>
                        <p class="card-text mb-1"><strong>Duration:</strong> {{ $course->duration ?: '—' }} hrs</p>
                        <p class="card-text mb-1"><strong>Files:</strong> {{ $course->files->count() }}</p>
                        <small class="text-muted mt-auto">Created: {{ $course->created_at->format('Y-m-d') }}</small>
                    </div>

                    {{-- 🔹 Footer (Admin actions only) --}}
                    @auth
                        @if (auth()->user()->role === 'admin' && empty($hideActions))
                            <div class="card-footer bg-transparent border-0 d-flex justify-content-between gap-2">
                                <a href="{{ route('courses.show', $course->id) }}" class="btn btn-info btn-sm text-white">
                                    <i class="fa fa-eye"></i> View
                                </a>

                                <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-warning btn-sm text-white">
                                    <i class="fa fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('courses.destroy', $course->id) }}" method="POST" 
                                      onsubmit="return confirm('Delete this course and all its files?')" 
                                      class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

    {{-- 🔹 Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {!! $courses->appends(['query' => request('query')])->links('pagination::bootstrap-5') !!}
    </div>
@endif


{{-- 🔹 Styles --}}
<style>
.course-card {
    transition: all 0.3s ease;
}
.course-card:hover {
    transform: translateY(-5px);
}
.overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(13, 110, 253, 0.75);
    opacity: 0;
    transition: opacity 0.4s ease;
}
.course-card:hover .overlay {
    opacity: 1;
}
.overlay .btn {
    animation: fadeInUp 0.5s ease;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.hover-shadow:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
}
.transition {
    transition: all 0.25s ease-in-out;
}
</style>

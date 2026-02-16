@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- 🔍 Header + Search --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <h2 class="fw-bold text-primary mb-0">
            <i class="fas fa-graduation-cap me-2"></i> My Enrolled Courses
        </h2>

        {{-- 🔎 Live Search Box --}}
        <div class="input-group shadow-sm" style="max-width: 320px;">
            <input 
                type="text" 
                id="search" 
                class="form-control border-0 shadow-none" 
                placeholder="Search enrolled courses..."
            >
            <button class="btn btn-primary px-3" type="button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>

    {{-- 🧭 Course Results Section --}}
    <div id="course-results">
        {{-- ✅ Partial view for AJAX updates --}}
        @include('courses.partials.my_courses_list', ['courses' => $courses])
    </div>

</div>

{{-- 💅 Styling Enhancements --}}
<style>
    /* Card Effects */
    .course-card {
        border: none;
        border-radius: 12px;
        transition: all 0.3s ease;
    }
    .course-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.1);
    }

    /* Overlay for fancy hover preview (optional for later enhancement) */
    .overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(13, 110, 253, 0.75);
        opacity: 0;
        transition: opacity 0.3s ease;
        border-radius: 12px;
    }
    .card:hover .overlay {
        opacity: 1;
    }

    /* Search Box Focus Glow */
    #search:focus {
        border-color: #0d6efd !important;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.25);
    }
</style>

{{-- ⚡ Live Search Script --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const resultsDiv = document.getElementById('course-results');
    let debounceTimer = null;

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        debounceTimer = setTimeout(() => {
            fetchCourses(query);
        }, 300);
    });

    function fetchCourses(query) {
        const url = new URL(`{{ route('courses.searchMy') }}`);
        url.searchParams.set('q', query);

        fetch(url)
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.text();
            })
            .then(html => {
                resultsDiv.innerHTML = html;
            })
            .catch(() => {
                resultsDiv.innerHTML = `
                    <div class="alert alert-danger text-center mt-4">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        Error loading results. Please try again.
                    </div>`;
            });
    }
});
</script>
@endsection

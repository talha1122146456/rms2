@extends('layouts.app')

@section('content')
<div class="container-fluid courses-alt-page text-light min-vh-100 py-4">

    {{-- 🔝 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3 border-bottom border-secondary pb-2">
        <h2 class="mb-0 fw-bold text-info"><i class="fa fa-book me-2"></i>Courses (Alt Page)</h2>
        <a href="{{ route('courses.create') }}" class="btn btn-info shadow-sm text-dark fw-semibold">
            <i class="fa fa-plus"></i> Add Course
        </a>
    </div>

    {{-- 🔍 Modern Live Search --}}
    <div class="mb-4">
        <div class="position-relative">
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-secondary">
                <i class="fa fa-search"></i>
            </span>

            <input
                type="text"
                id="search"
                class="form-control ps-5 pe-5 py-2 bg-dark text-light rounded-pill border border-secondary"
                placeholder="Search courses by title or instructor..."
                value="{{ request('query') }}"
            >

            <button
                class="btn position-absolute top-50 end-0 translate-middle-y text-secondary"
                id="clear-search"
                type="button"
                style="background: transparent; border: none;"
            >
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>

    {{-- 📋 Course List --}}
    <div id="courseList">
        @include('courses.partials.course_cards', ['courses' => $courses, 'hideActions' => true])
    </div>
</div>

{{-- 🔁 AJAX Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(function () {
    const searchRoute = "{{ route('courses.search') }}";
    let searchTimer = null;

    $('#search').on('input', function () {
        clearTimeout(searchTimer);
        const query = $(this).val().trim();
        searchTimer = setTimeout(() => { fetchCourses(query); }, 300);
    });

    $('#clear-search').on('click', function () {
        $('#search').val('').trigger('input');
        clearTimeout(searchTimer);
        fetchCourses('');
    });

    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const query = $('#search').val().trim();
        fetchCourses(query, url);
    });

    function fetchCourses(query = '', url = searchRoute) {
        $.ajax({
            url: url,
            type: 'GET',
            data: { query, hideActions: true },
            beforeSend: function() {
                $('#courseList').html(`
                    <div class="text-center py-5 text-secondary">
                        <i class="fa fa-spinner fa-spin fa-2x mb-2"></i>
                        <p>Loading courses...</p>
                    </div>
                `);
            },
            success: function (data) {
                $('#courseList').html(data.html);
                try {
                    const base = "{{ route('courses.index1') }}";
                    history.replaceState(null, '', query ? base + '?query=' + encodeURIComponent(query) : base);
                } catch {}
            },
            error: function () {
                $('#courseList').html(`
                    <div class="alert alert-danger text-center">
                        ⚠️ Error loading results. Please try again.
                    </div>
                `);
            }
        });
    }

    const initialQuery = $('#search').val().trim();
    if (initialQuery.length) fetchCourses(initialQuery);
});
</script>

{{-- 🌌 DARK + GLASSMORPHISM STYLING --}}
<style>
.courses-alt-page {
    background: radial-gradient(circle at top left, #0d1b2a, #000000);
    color: #e9ecef;
    font-family: 'Poppins', sans-serif;
    backdrop-filter: blur(12px);
    min-height: 100vh;
}

/* Header */
.courses-alt-page h2 {
    letter-spacing: 0.6px;
    font-size: 1.7rem;
}

/* Buttons */
.courses-alt-page .btn-info {
    border-radius: 25px;
    padding: 0.5rem 1.3rem;
    background: linear-gradient(135deg, #00b4d8, #0077b6);
    border: none;
    transition: all 0.3s ease;
}
.courses-alt-page .btn-info:hover {
    background: linear-gradient(135deg, #0077b6, #00b4d8);
    transform: translateY(-2px);
    box-shadow: 0 4px 14px rgba(0, 180, 216, 0.4);
}

/* Search box */
.courses-alt-page #search {
    background: rgba(30, 30, 30, 0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
    transition: all 0.3s ease;
}
.courses-alt-page #search:focus {
    border-color: #00b4d8;
    box-shadow: 0 0 10px rgba(0, 180, 216, 0.4);
}
.courses-alt-page #search::placeholder {
    color: #aaa;
}

/* 🧊 Glass Cards */
.courses-alt-page .card {
    background: rgba(255, 255, 255, 0.05) !important;
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.08);
    border-radius: 20px;
    transition: all 0.35s ease-in-out;
    color: #f1f1f1;
}
.courses-alt-page .card:hover {
    transform: translateY(-6px) scale(1.02);
    border-color: rgba(0, 180, 216, 0.4);
    box-shadow: 0 8px 25px rgba(0, 180, 216, 0.25);
}

/* Card text */
.courses-alt-page .card-title {
    color: #90e0ef;
    font-weight: 600;
}
.courses-alt-page .card-text {
    color: #adb5bd;
}

/* Links */
.courses-alt-page a {
    color: #00b4d8;
    text-decoration: none;
}
.courses-alt-page a:hover {
    color: #90e0ef;
}

/* Pagination */
.courses-alt-page .pagination .page-link {
    background: rgba(255,255,255,0.05);
    color: #00b4d8;
    border: 1px solid rgba(255,255,255,0.08);
    backdrop-filter: blur(8px);
}
.courses-alt-page .pagination .page-item.active .page-link {
    background: #00b4d8;
    color: #121212;
    border: none;
}
.courses-alt-page .pagination .page-link:hover {
    background: #00b4d8;
    color: #121212;
}

/* Scrollbar */
.courses-alt-page ::-webkit-scrollbar {
    width: 8px;
}
.courses-alt-page ::-webkit-scrollbar-thumb {
    background: #00b4d8;
    border-radius: 8px;
}
.courses-alt-page ::-webkit-scrollbar-track {
    background: #1e1e1e;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(15px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.courses-alt-page .card {
    animation: fadeInUp 0.6s ease both;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .courses-alt-page {
        padding: 20px;
    }
    .courses-alt-page h2 {
        font-size: 1.4rem;
    }
}
</style>
@endsection

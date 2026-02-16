@extends('layouts.app')

@section('content')
<div class="container mt-5">

    {{-- 🔹 Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="fw-bold text-primary mb-0">
            <i class="fa fa-graduation-cap me-2"></i> All Courses
        </h2>
        <a href="{{ route('courses.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Add New Course
        </a>
    </div>

    {{-- 🔍 Live Search --}}
    <div class="input-group mb-4" style="max-width: 400px;">
        <input type="text" id="search" class="form-control" placeholder="Search by title or instructor">
        <button class="btn btn-primary" id="btn-search" title="Search">
            <i class="fas fa-search"></i>
        </button>
        <button class="btn btn-outline-secondary" id="btn-clear" title="Clear Search">
            <i class="fas fa-times"></i>
        </button>
    </div>

    {{-- ✅ Flash Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fa fa-check-circle me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm">
            <i class="fa fa-exclamation-circle me-1"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- 📋 Courses Table --}}
    <div id="courses-table">
        @include('courses.partials.courses_table', ['courses' => $courses])
    </div>
</div>

{{-- 💅 Styles --}}
<style>
.table-hover tbody tr {
    cursor: pointer;
    transition: background-color 0.25s ease;
}
.table-hover tbody tr:hover {
    background-color: #f3f7ff;
}
#btn-clear {
    border-left: none;
}
</style>

{{-- ⚡ Live Search Script --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const clearBtn = document.getElementById('btn-clear');
    const searchBtn = document.getElementById('btn-search');
    const resultsDiv = document.getElementById('courses-table');
    let timer = null;

    // 🔍 Live search (debounced typing)
    searchInput.addEventListener('keyup', () => {
        clearTimeout(timer);
        timer = setTimeout(() => fetchCourses(searchInput.value.trim()), 300);
    });

    // 🔘 Manual search click
    searchBtn.addEventListener('click', () => {
        fetchCourses(searchInput.value.trim());
    });

    // ❌ Clear button
    clearBtn.addEventListener('click', () => {
        searchInput.value = '';
        fetchCourses('');
    });

    // 📡 Fetch filtered courses
    function fetchCourses(query) {
        fetch(`{{ route('courses.search') }}?query=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) throw new Error('Network error');
                return response.text();
            })
            .then(html => {
                resultsDiv.innerHTML = html;
                makeRowsClickable();
            })
            .catch(() => {
                resultsDiv.innerHTML = `
                    <div class="alert alert-danger text-center mt-4">
                        ⚠️ Error loading results. Please try again.
                    </div>`;
            });
    }

    // 🖱 Make table rows clickable
    function makeRowsClickable() {
        document.querySelectorAll('tr[data-href]').forEach(row => {
            row.addEventListener('click', () => {
                window.location.href = row.dataset.href;
            });
        });
    }

    makeRowsClickable(); // apply on initial load
});
</script>
@endsection

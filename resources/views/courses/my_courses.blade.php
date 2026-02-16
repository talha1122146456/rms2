@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4 fw-bold text-primary">My Enrolled Courses</h2>

    @if($courses->isEmpty())
        <div class="alert alert-info">
            You are not enrolled in any courses yet.
        </div>
    @else
        {{-- Include the reusable course card partial --}}
        @include('courses.partials.course_cards', [
            'courses' => $courses,
            'hideActions' => true
        ])
    @endif
</div>
@endsection

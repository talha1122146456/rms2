@if($courses->count())
<div class="table-responsive">
    <table class="table table-hover align-middle text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Title</th>
                <th>Instructor</th>
                <th>Duration</th>
                <th>Files</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($courses as $index => $course)
            <tr>
                <td>{{ $index + $courses->firstItem() }}</td>
                <td>
                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" width="70" height="50" class="rounded shadow-sm" alt="Course Image">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $course->title }}</td>
                <td>{{ $course->instructor ?? 'N/A' }}</td>
                <td>{{ $course->duration ? $course->duration . ' hrs' : 'N/A' }}</td>
                <td>{{ $course->files->count() }}</td>
                <td>
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="{{ route('courses.edit', $course->id) }}" class="btn btn-sm btn-warning">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('courses.destroy', $course->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this course?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-center mt-3">
    {{ $courses->links('pagination::bootstrap-5') }}
</div>
@else
<div class="alert alert-warning text-center">
    No courses found.
</div>
@endif

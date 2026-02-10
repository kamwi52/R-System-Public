@extends('layouts.app')
@section('title', 'Edit Grading Scale')
@section('content')
<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h3>Edit Grading Scale: {{ $gradingScale->name }}</h3>
        </div>
        <div class="content-body">
            <form action="{{ route('admin.grading-scales.update', $gradingScale->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Scale Name</label>
                    <input type="text" name="name" class="form-control" value="{{ $gradingScale->name }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Grades</label>
                    <table class="table" style="border: 1px solid #e5e7eb;">
                        <thead>
                            <tr>
                                <th>Grade</th>
                                <th>Min Score</th>
                                <th>Max Score</th>
                                <th>Remark</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="grades-body">
                            @foreach($gradingScale->grades as $index => $grade)
                            <tr>
                                <input type="hidden" name="grades[{{ $index }}][id]" value="{{ $grade->id }}">
                                <td><input type="text" name="grades[{{ $index }}][grade_name]" class="form-control" value="{{ $grade->grade_name }}" required></td>
                                <td><input type="number" name="grades[{{ $index }}][min_score]" class="form-control" value="{{ $grade->min_score }}" required></td>
                                <td><input type="number" name="grades[{{ $index }}][max_score]" class="form-control" value="{{ $grade->max_score }}" required></td>
                                <td><input type="text" name="grades[{{ $index }}][remark]" class="form-control" value="{{ $grade->remark }}"></td>
                                <td><button type="button" class="action-btn" onclick="removeRow(this)" style="color: #ef4444; border:none; background:none;"><i class="fas fa-trash"></i></button></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <button type="button" class="btn-secondary" onclick="addGradeRow()" style="margin-top: 10px; font-size: 0.85rem;">
                        <i class="fas fa-plus"></i> Add Grade Row
                    </button>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.grading-scales.index') }}" class="btn-secondary">Cancel</a>
                    <button type="submit" class="btn-primary">Update Grading Scale</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Initialize rowCount based on existing rows to avoid index collision
    let rowCount = {{ $gradingScale->grades->count() }};

    function addGradeRow() {
        const tbody = document.getElementById('grades-body');
        const tr = document.createElement('tr');
        // Note: New rows don't have an ID input, so the controller will treat them as new inserts
        tr.innerHTML = `
            <input type="hidden" name="grades[${rowCount}][id]" value="">
            <td><input type="text" name="grades[${rowCount}][grade_name]" class="form-control" required></td>
            <td><input type="number" name="grades[${rowCount}][min_score]" class="form-control" required></td>
            <td><input type="number" name="grades[${rowCount}][max_score]" class="form-control" required></td>
            <td><input type="text" name="grades[${rowCount}][remark]" class="form-control"></td>
            <td><button type="button" class="action-btn" onclick="removeRow(this)" style="color: #ef4444; border:none; background:none;"><i class="fas fa-trash"></i></button></td>
        `;
        tbody.appendChild(tr);
        rowCount++;
    }

    function removeRow(btn) {
        const tbody = document.getElementById('grades-body');
        if (tbody.children.length > 1) {
            // If the row has an ID, removing it from DOM means it won't be sent in the request.
            // The controller logic: $gradingScale->grades()->whereNotIn('id', $submittedGradeIds)->delete();
            // handles the deletion of missing IDs.
            btn.closest('tr').remove();
        } else {
            alert('You must have at least one grade row.');
        }
    }
</script>
@endsection

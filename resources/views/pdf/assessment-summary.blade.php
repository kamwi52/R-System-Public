<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assessment Summary</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h1 { margin: 0; font-size: 18px; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Assessment Result Summary</h1>
        <p><strong>Class:</strong> {{ $classSection->name }} | <strong>Subject:</strong> {{ $assessment->subject->name }}</p>
        <p><strong>Assessment:</strong> {{ $assessment->title ?? $assessment->name }} | <strong>Max Score:</strong> {{ $assessment->max_score ?? 100 }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 45%;">Student Name</th>
                <th style="width: 30%;">Student ID</th>
                <th style="width: 20%;" class="text-right">Score</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $index => $student)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->id }}</td>
                    <td class="text-right">
                        {{ $results[$student->id]->score ?? '-' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
    <div style="margin-top: 20px; font-size: 10px; color: #777;">
        Generated on {{ now()->format('Y-m-d H:i') }}
    </div>
</body>
</html>
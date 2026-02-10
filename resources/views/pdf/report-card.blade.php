<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Report Card</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 20px; }
        .header h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0; font-size: 14px; }
        
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 5px; }
        .label { font-weight: bold; width: 120px; }

        .grades-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .grades-table th, .grades-table td { border: 1px solid #999; padding: 8px; text-align: center; font-size: 12px; }
        .grades-table th { background-color: #f0f0f0; text-transform: uppercase; }
        .grades-table .subject-col { text-align: left; font-weight: bold; }

        .footer { margin-top: 50px; }
        .signature-box { float: left; width: 40%; border-top: 1px solid #333; padding-top: 10px; text-align: center; font-size: 12px; }
        .signature-box.right { float: right; }
        
        .clearfix::after { content: ""; clear: both; display: table; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>School Name High School</h1>
            <p>123 Education Lane, Knowledge City</p>
            <p><strong>Student Report Card</strong></p>
        </div>

        <table class="info-table">
            <tr>
                <td class="label">Student Name:</td>
                <td>{{ $student->name }}</td>
                <td class="label">Session:</td>
                <td>{{ $session->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td class="label">Student ID:</td>
                <td>{{ $student->id }}</td>
                <td class="label">Term:</td>
                <td>{{ $term->name }}</td>
            </tr>
            <tr>
                <td class="label">Class:</td>
                <td>{{ $classSection->name }}</td>
                <td class="label">Date:</td>
                <td>{{ now()->format('d M, Y') }}</td>
            </tr>
        </table>

        <table class="grades-table">
            <thead>
                <tr>
                    <th class="subject-col">Subject</th>
                    <th>Assessments Breakdown</th>
                    <th>Total Score</th>
                    <th>Max Score</th>
                    <th>Percentage</th>
                    <th>Grade</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reportData as $data)
                <tr>
                    <td class="subject-col">
                        {{ $data['subject'] }}
                        <br><span style="font-weight: normal; font-size: 10px; color: #555;">{{ $data['code'] }}</span>
                    </td>
                    <td style="text-align: left;">
                        @foreach($data['assessments'] as $assessment)
                            <div style="font-size: 10px;">
                                {{ $assessment['name'] }}: <strong>{{ $assessment['score'] }}</strong> / {{ $assessment['max'] }}
                            </div>
                        @endforeach
                    </td>
                    <td>{{ $data['total_score'] }}</td>
                    <td>{{ $data['max_score'] }}</td>
                    <td>{{ number_format($data['percentage'], 1) }}%</td>
                    <td style="font-weight: bold;">{{ $data['grade'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div style="margin-bottom: 40px;">
            <strong>Remarks:</strong>
            <div style="border-bottom: 1px solid #ccc; height: 20px; margin-top: 5px;"></div>
            <div style="border-bottom: 1px solid #ccc; height: 20px; margin-top: 5px;"></div>
        </div>

        <div class="footer clearfix">
            <div class="signature-box">
                Class Teacher's Signature
            </div>
            <div class="signature-box right">
                Principal's Signature
            </div>
        </div>
        
        <div style="text-align: center; font-size: 10px; color: #999; margin-top: 30px;">
            This report card was generated electronically by R-System.
        </div>
    </div>
</body>
</html>
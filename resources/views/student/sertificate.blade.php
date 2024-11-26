<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Georgia&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 40px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header h1 {
            font-family: 'Georgia', serif;
            color: #333;
            margin-bottom: 10px;
        }
        .header h2 {
            font-family: 'Georgia', serif;
            color: #666;
            font-size: 1.2em;
        }
        .header h3 {
            font-size: 1em;
            color: #777;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table th, .main-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .main-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .main-table td {
            background-color: #fff;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 20px;
            color: white;
            font-size: 14px;
        }
        .bg-success { background-color: #28a745; }
        .bg-primary { background-color: #007bff; }
        .bg-warning { background-color: #ffc107; }
        .bg-danger { background-color: #dc3545; }
        .element-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .element-table th, .element-table td {
            border: 1px solid #ddd;
            padding: 10px 15px;
            text-align: left;
        }
        .element-table th {
            background-color: #ececec;
            font-weight: bold;
        }
        .element-badge {
            padding: 6px 12px;
            border-radius: 15px;
            font-size: 13px;
            color: white;
            text-align: center;
        }
        .element-success { background-color: #28a745; }
        .element-fail { background-color: #dc3545; }
        .certificate-footer {
            text-align: center;
            margin-top: 30px;
            font-size: 0.9em;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Hasil Ujian</h1>
        @foreach ($students as $student)
        <h2>Atas Nama: {{ $student['student_name'] }}</h2>
        @endforeach
        <h3>Standar Kompetensi: {{ $standard->unit_title }}</h3>
    </div>

    <!-- Main table displaying student information -->
    <table class="main-table">
        <thead>
            <tr>
                <th>Nama Siswa</th>
                <th>Final Score (%)</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $index => $student)
                <tr>
                    <td>{{ $student['student_name'] }}</td>
                    <td>{{ $student['final_score'] }}</td>
                    <td>
                        <span class="badge
                            @if ($student['status'] == 'Sangat Kompeten') bg-success
                            @elseif ($student['status'] == 'Kompeten') bg-primary
                            @elseif ($student['status'] == 'Cukup Kompeten') bg-warning
                            @else bg-danger
                            @endif">
                            {{ $student['status'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Element table displaying detailed evaluation criteria -->
    @foreach ($students as $student)
    <table class="element-table">
        <thead>
            <tr>
                <th>Criteria</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($student['elements'] as $element)
                <tr>
                    <td>{{ $element['criteria'] }}</td>
                    <td>
                        <span class="element-badge
                            @if ($element['status'] == 'Kompeten') element-success
                            @else element-fail
                            @endif">
                            {{ $element['status'] }}
                        </span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @endforeach

    <!-- Footer (Optional) -->
    <div class="certificate-footer">
        <p>Terima kasih telah mengikuti ujian. Semoga sukses!</p>
    </div>
</body>
</html>

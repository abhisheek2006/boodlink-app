<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #212529; }
        h2 { color: #D32F2F; margin-bottom: 4px; }
        .generated { color: #6c757d; margin-bottom: 16px; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dee2e6; padding: 6px 8px; text-align: left; }
        th { background: #F8F9FA; }
        tr:nth-child(even) { background: #fafafa; }
    </style>
</head>
<body>
    <h2>Blood Link — {{ $title }}</h2>
    <div class="generated">Generated {{ now()->format('d M Y, h:i A') }}</div>

    @if ($rows->isEmpty())
        <p>No data available for this report.</p>
    @else
        <table>
            <thead>
                <tr>
                    @foreach (array_keys((array) $rows->first()) as $column)
                        <th>{{ $column }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($rows as $row)
                    <tr>
                        @foreach ((array) $row as $value)
                            <td>{{ $value }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>

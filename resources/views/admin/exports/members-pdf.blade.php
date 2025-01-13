<!DOCTYPE html>
<html>
<head>
    <title>Members Export</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h2>Members List</h2>
    <table>
        <thead>
            <tr>
                @foreach($fields as $field)
                    <th>{{ ucwords(str_replace('_', ' ', $field)) }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($membersData as $member)
            <tr>
                @foreach($fields as $field)
                    <td>{{ $member->$field }}</td>
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html> 
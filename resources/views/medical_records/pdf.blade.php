<!DOCTYPE html>
<html>

<head>

    <title>Medical Record PDF</title>

    <style>

        body{
            font-family: Arial, sans-serif;
        }

        table{
            width:100%;
            border-collapse: collapse;
        }

        table, th, td{
            border:1px solid black;
            padding:10px;
        }

        h2{
            text-align:center;
        }

    </style>

</head>

<body>

    <h2>Student Medical Record</h2>

    <table>

        <tr>
            <th>Student Name</th>
            <td>{{ $record->student->full_name }}</td>
        </tr>

        <tr>
            <th>Diagnosis</th>
            <td>{{ $record->diagnosis }}</td>
        </tr>

        <tr>
            <th>Treatment</th>
            <td>{{ $record->treatment }}</td>
        </tr>

        <tr>
            <th>Medical Status</th>
            <td>{{ $record->medical_status }}</td>
        </tr>

        <tr>
            <th>Checkup Date</th>
            <td>{{ $record->checkup_date }}</td>
        </tr>

    </table>

</body>

</html>
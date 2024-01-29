<!DOCTYPE html>
<html>

<head>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        .header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            padding: 20px;
        }

        .school-info {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin: 20px;
        }

        .school-info h2 {
            margin: 0;
        }

        .school-info p {
            margin: 5px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        .print-date {
            font-size: 10px;
            float: right;
            margin-bottom: 20px;
        }

        hr {
            border: dashed 2px;
            width: 95%;
            color: #000;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>I.T.A</h2>
    </div>

    <div class="school-info">
        <div>
            <h2>Institut de Technologie Abidjan</h2>
            <p>Abidjan-Macory (Côte d'ivoire)</p>
            <p>Contact: 343434343434</p>
            <p>Email: info.ita@school.com</p>
            <p><b>Liste des Etudiants</b></p>
        </div>
        <br>
        <h2 class="class-name text-center">
            Classe: {{ $allData[0]->student_class->name }}
        </h2>
    </div>
    </div>

    <table>

        <tr>
            <thead>
                <th>Numero</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Presence</th>
            </thead>
        </tr>
        <tbody>
            @php
            $Sn= 1;
            @endphp
            @foreach($allData as $value)
            <tr>
                <td>{{$Sn++}}</td>
                <td>{{ $value['student']['name'] }}</td>
                <td>{{$value['student']['email']}}</td>
                <td>{{ $value['student']['mobile']}}</td>
                <td></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="print-date">
        Print Data: {{ date("d M Y") }}
    </div>

    <hr>
</body>

</html>
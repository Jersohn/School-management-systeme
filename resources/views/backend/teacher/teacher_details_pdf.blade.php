<!DOCTYPE html>
<html>

<head>
    <style>
        #customers {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        #customers td,
        #customers th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        #customers tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        #customers tr:hover {
            background-color: #ddd;
        }

        #customers th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>

<body>


    <table id="customers">
        <tr>
            <td>
                <h2>
                    I.T.A

                </h2>
            </td>
            <td>
                <h2>Institut de Technologie Abidjan</h2>
                <p>School Address:Abidjan (Côte d'Ivoire)</p>
                <p>Phone : 343434343434</p>
                <p>Email : info.ita@school.com</p>

            </td>
        </tr>


    </table>



    <table id="customers">
        <tr>
            <th width="10%">Sl</th>
            <th width="45%">Teacher Details</th>
            <th width="45%">Teacher Data</th>
        </tr>
        <tr>
            <td>1</td>
            <td><b>Teacher Name</b></td>
            <td>{{ $details['teacher']['name'] }}</td>
        </tr>
        <tr>
            <td>2</td>
            <td><b>Teacher ID No</b></td>
            <td>{{ $details['teacher']['id_no'] }}</td>
        </tr>


        <tr>
            <td>6</td>
            <td><b>Mobile Number </b></td>
            <td>{{ $details['teacher']['mobile'] }}</td>
        </tr>
        <tr>
            <td>7</td>
            <td><b>Address</b></td>
            <td>{{ $details['teacher']['address'] }}</td>
        </tr>
        <tr>
            <td>8</td>
            <td><b>Gender</b></td>
            <td>{{ $details['teacher']['gender'] }}</td>
        </tr>



        <tr>
            <td>12</td>
            <td><b>Year </b></td>
            <td>{{ $details['teacher_year']['name'] }}</td>
        </tr>
        <tr>
            <td>13</td>
            <td><b>Classes </b></td>
            <td>
                @foreach(json_decode($details['class_id']) as $classId)

                @php
                $studentClass = \App\Models\StudentClass::find((int)$classId);
                @endphp


                {{ $studentClass->name }},

                @endforeach
            </td>
        </tr>

        <tr>
            <td>14</td>
            <td><b>Courses </b></td>
            <td>
                @foreach(json_decode($details['subject_id']) as $subjectId)
                @php
                $teacherSubject = \App\Models\SchoolSubject::find((int)$subjectId);
                @endphp
                {{$teacherSubject->name }},
                @endforeach
            </td>

        </tr>



        <tr>
            <td>15</td>
            <td><b>Email </b></td>
            <td>{{ $details['teacher']['email'] }}</td>
        </tr>

    </table>
    <br> <br>
    <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>

</body>

</html>
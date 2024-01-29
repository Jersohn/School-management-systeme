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
      <h2 style="text-align: center;">Institut de Technologie Abidjan</h2>
      <p style="text-align: center;">Abidjan-Macory (Côte d'ivoire)</p>
      <p style="text-align: center;">Contact: 343434343434</p>
      <p style="text-align: center;">Email: info.ita@school.com</p>

    </div>


  </div>



    <div>
       <h2 style="color:#4CAF50;text-align: center;">Emploi du temps de M. {{$teacherName}} | {{ date("Y") }}</h2>
    </div>
    <hr>
    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th></th> <!-- Cellule vide pour l'angle supérieur gauche -->
                @for ($hour = 7; $hour <= 17; $hour++) <th>{{ str_pad($hour, 2, '0', STR_PAD_LEFT) }}:00</th>
                    @endfor
            </tr>
        </thead>
        <tbody>
            @foreach (['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'] as $day)
            <tr>
                <td>{{ $day }}</td>
                @for ($hour = 7; $hour <= 17; $hour++) <td>
                    <!-- Affichage des cours pour chaque heure -->
                    @php
                    $currentHour = sprintf("%02d", $hour) . ":00:00";
                    $currentHourSchedules = $teacherSchedule->where('day_of_week', $day)
                    ->where('start_time', '<=', $currentHour)->where('end_time', '>', $currentHour);
                        @endphp

                        <!-- Vérification des cours pour cette heure -->
                        @foreach ($currentHourSchedules as $schedule)
                        <p style="color: cornflowerblue;">{{ $schedule->subject->name }}</p>
                        <small style="font-style: italic;">{{ $schedule->studentClass->name }}</small><br>
                        <small style="font-weight: bold;">{{ $schedule->classroom->name }}</small><br>
                        @endforeach
                        </td>
                        @endfor
            </tr>
            @endforeach
        </tbody>
    </table>


    <br> <br>
    <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>

</body>

</html>
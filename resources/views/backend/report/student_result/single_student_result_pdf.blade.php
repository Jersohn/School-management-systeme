<!DOCTYPE html>
<html>
<head>
<style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
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
 <br> <br>
 <strong>Résultat : </strong>{{ $allData['0']['student_class']['name'] }} | {{ $allData['0']['exam_type']['name'] }} 
 <br> <br>
<!-- Display Student Name and Subjects in the Top Row -->
<!-- Display Student Name and Subjects in the Top Row -->
<table id="customers">
  <tr>
  <th>Student Name</th>
    @php
      // Get unique subject names
      $uniqueSubjects = collect($allData)->pluck('subject.name')->unique();
    @endphp

    @foreach($uniqueSubjects as $subject)
      <th>{{ $subject }}</th>
    @endforeach
  </tr>


  <!-- Display Marks in the Rows Below -->
  @php
    $students = collect($allData)->pluck('student')->unique();
  @endphp

  @foreach($students as $student)
    <tr>
      <td>{{ $student['name'] ?? '' }}</td>
      @foreach($allData->where('student_id', $student['id']) as $subjectData)
        <td>{{ $subjectData['marks'] ?? '' }}</td>
      @endforeach
    </tr>
  @endforeach
</table>


<br> <br>
  <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>

<hr style="border: dashed 2px; width: 95%; color: #000000; margin-bottom: 50px">

 
 

</body>
</html>

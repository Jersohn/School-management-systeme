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
        <p>School Address</p>
        <p>Phone : 343434343434</p>
        <p>Email : info.ita@school.com</p>
        <p> <b>Student ID Card </b> </p>

      </td>
    </tr>


  </table>

  @foreach($allData as $value)
  <table id="customers">

    <tr>
      <td>IMAGE</td>
      <td>ITA </td>
      <td> Student Id Card</td>

    </tr>

    <tr>
      <td>Name : {{ $value['student']['name'] }}</td>
      <td>Session : {{ $value['student_year']['name'] }}</td>
      <td> Class : {{ $value['student_class']['name'] }}</td>

    </tr>


    <tr>

      <td>ID No : {{ $value['student']['id_no'] }}</td>
      <td> Mobile:{{ $value['student']['mobile'] }} </td>
      <td> Group:{{ $value['group']['name'] }} </td>

    </tr>



  </table>
  <br>
  <hr>
  <br>
  @endforeach

  <br> <br>
  <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>

  <hr style="border: dashed 2px; width: 95%; color: #000000; margin-bottom: 50px">




</body>

</html>
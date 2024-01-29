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



  <h2 style="text-align: center;">Détails des paiements</h2>
  @php
  $registrationfee = App\Models\FeeCategoryAmount::where('fee_category_id', '2')
  ->where('class_id', $details->class_id)
  ->first();

  $originalfee = $registrationfee->amount;
  $discount = $details['discount']['discount'];
  $discounttablefee = $discount / 100 * $originalfee;
  $finalfee = (float) $originalfee - (float) $discounttablefee;

  $amountPaid = App\Models\StudentPayment::where('class_id', $details->class_id)
  ->where('student_id', $details->student_id)
  ->sum('amount');

  $remainingFees = '';

  if ($amountPaid === $finalfee) {
  $remainingFees = 'Soldé';
  } else {
  $remainingFees = $finalfee - (float) $amountPaid;
  }
  @endphp
  <table id="customers">
    <tr>
      <th width="10%">N°</th>
      <th width="45%">Details Etudiant</th>
      <th width="45%">Données</th>
    </tr>
    <tr>
      <td>1</td>
      <td><b>Identifiant</b></td>
      <td>{{ $details['student']['id_no'] }}</td>
    </tr>

    <tr>
      <td>2</td>
      <td><b>Nom</b></td>
      <td>{{ $details['student']['name'] }}</td>
    </tr>


    <tr>
      <td>3</td>
      <td><b>Session</b></td>
      <td>{{ $details['student_year']['name'] }}</td>
    </tr>
    <tr>
      <td>4</td>
      <td><b>Classe </b></td>
      <td>{{ $details['student_class']['name'] }}</td>
    </tr>

    <tr>
      <td>5</td>
      <td><b>Frais de scolarité</b></td>
      <td>{{ $originalfee }} $</td>
    </tr>
    <tr>
      <td>6</td>
      <td><b>Reduction </b></td>
      <td>{{ $discount }} %</td>
    </tr>

    <tr>
      <td>7</td>
      <td><b>Frais à payer </b></td>
      <td>{{ $finalfee }} $</td>
    </tr>
    <tr>
      <td>8</td>
      <td><b>Montant payé </b></td>
      <td>{{ $amountPaid }} $</td>
    </tr>
    <tr>
      <td>9</td>
      <td><b>Reste à payer </b></td>
      <td style="color: red;">{{ $remainingFees}} $</td>
    </tr>
  </table>

  <h3 style="text-align: center;">Historique des paiements</h3>
  <table id="customers">

    <tr>
      <th width="10%">N°</th>
      <th width="30%">Date</th>
      <th width="30%">Montant</th>
      <th width="30%">Moyen de paiement</th>
    </tr>
    @forelse($paymentHistory as $key => $payment)
    <tr>
      <td>{{ $key + 1 }}</td>
      <td>{{ $payment->created_at->formatLocalized('%d %B %Y') }}</td>

      <td>{{ $payment->amount }} $</td>
      <td>{{ $payment->payment_method }}</td>
    </tr>
    @empty
    <tr>
      <td colspan="4" style="text-align: center;">Aucun paiement effectué pour le moment.</td>
    </tr>
    @endforelse
  </table>




  <i style="font-size: 10px; float: right;">Print Data : {{ date("d M Y") }}</i>
  <hr style="border: dashed 2px; width: 95%; color: #000000; margin-bottom: 50px">












</body>

</html>
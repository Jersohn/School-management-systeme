<!DOCTYPE html>
<html lang="fr">

<head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Class schedule</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />


</head>

<body class="bg-light">




  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <br>

      <h1 class="text-center text-info">Emploi du Temps - {{ $teacherName}}</h1>


      <a href="{{ route('dashboard') }}" class="btn btn-rounded btn-info mb-5">
        Retour
      </a>


      <!-- Main content -->
      <section class="content">
        <div class="row">

          <div id="calendar"></div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->

    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
  <script>

    document.addEventListener('DOMContentLoaded', function () {
      // Récupérer les données via AJAX
      $.ajax({
        url: "{{ route('teacher.schedule.view') }}", // Route vers la méthode du contrôleur
        type: "GET",
        success: function (response) {
          // Initialiser le calendrier FullCalendar avec les données reçues
          $('#calendar').fullCalendar({

            header: {
              left: 'prev,next',
              center: 'title',
              right: 'today'
            },
            defaultView: 'agendaWeek',

            dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
            dayNamesShort: ['Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam'],
            monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
            monthNamesShort: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
            buttonText: {
              today: 'Aujourd\'hui',
              month: 'Mois',
              week: 'Semaine',
              day: 'Jour'
            },
            minTime: '07:00:00',

            events: response,
            eventRender: function (event, element, view) {
              // Personnaliser l'affichage des événements
              element.find('.fc-content').html(
                '<div class="event-details">' +
                '<div class="detail"><span class="teacher-name">' + event.subject + '</span></div>' +
                '<div class="detail"><em>' + event.class + '</em></div>' +
                '<div class="detail"><strong>' + event.classroom + '</strong></div>' +

                '<div class="detail"><span class="event-time">De ' + event.start.format('HH:mm') + ' à ' + event.end.format('HH:mm') + '</span></div>' +
                '</div>'
              );
            },
            // Autres options du calendrier...
          });
        },
        error: function (xhr, status, error) {
          console.error(xhr.responseText);
          alert("Error loading student schedule. Please try again.");
        }
      });
    });

  </script>







</body>

</html>
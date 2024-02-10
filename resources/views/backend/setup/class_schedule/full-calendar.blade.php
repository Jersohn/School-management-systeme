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

            <h1 class="text-center text-info">Emploi du Temps - {{ $selectedClass}}</h1>
            <a href="#" type="button" class="btn btn-rounded btn-outline-info mb-5" id="addEventBtn">Ajouter un emploi
                du temps
            </a>

            <a href="{{ route('class.view') }}" style="float: right;" class="btn btn-rounded btn-info mb-5">
                Retour
            </a>


            <!-- Main content -->
            <section class="content">
                <div class="row">

                    <div id="calendar"></div>

                    <div class="modal" id="eventModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel">Ajout Emploi du Temps</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="eventForm">
                                        <div class="form-group">
                                            <label for="class_id">Classe</label>
                                            <input type="text" name="class_id" id="classSelected" class="form-control"
                                                value="{{ $selectedClass}}" readonly>
                                        </div>

                                        <div class="form-group">
                                            <label for="teacher_id">Enseignant</label>
                                            <select name="teacher_id" id="teacherSelected" class="form-control">
                                                <option value="">Selectionnez un Enseignant</option>
                                                @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="subject_id">Matière</label>
                                            <select name="subject_id" id="subjectSelected" class="form-control">
                                                <option value="">Sélectionnez une Matière</option>
                                                <!-- Options des matières seront ajoutées ici via JavaScript -->
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="start_time">Debut</label>
                                            <input type="datetime-local" name="start_time" id="startDateTime"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="end_time">Fin</label>
                                            <input type="datetime-local" name="end_time" id="endDateTime"
                                                class="form-control">
                                        </div>

                                        <div class="form-group">
                                            <label for="classroom_id">Salle</label>
                                            <select name="classroom_id" id="classroomSelected" class="form-control">
                                                <option value="">Selectionnez une salle</option>
                                                @foreach($classrooms as $classroom)
                                                <option value="{{ $classroom->name }}">{{ $classroom->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" id="saveEventBtn">Save Event</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal de détails et suppression -->




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

        $(document).ready(function () {
            $("#teacherSelected").on("change", function () {
                var teacherId = $(this).val();
                // Effectuer une requête AJAX pour récupérer les matières enseignées par le professeur sélectionné
                $.ajax({
                    url: "{{ route('get.subjects') }}",
                    type: "GET",
                    data: {
                        teacherSelected: teacherId
                    },
                    success: function (data) {
                        // Effacer les options existantes du select des matières
                        $("#subjectSelected").empty();
                        // Ajouter les nouvelles options basées sur les matières retournées par la requête AJAX
                        data.forEach(function (subjectName) {
                            // Ajouter une option avec le nom de la matière
                            $("#subjectSelected").append(
                                '<option value="' + subjectName + '">' + subjectName + '</option>'
                            );
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error(xhr.responseText);

                        try {
                            var errorMessage = JSON.parse(xhr.responseText).error;
                            alert("Error: " + errorMessage);
                        } catch (e) {
                            alert("Error showing subject. Please try again.");
                        }
                    }
                });

            });
        });

    </script>
    <script>
        var scheduleData = @json($schedules);// Convertir les données en JSON
        var selectedClass = "{{$selectedClass}}"; // Classe actuellement sélectionnée



        $(document).ready(function () {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            var calendar = $('#calendar').fullCalendar({


                editable: true,
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                defaultView: 'agendaWeek',
                views: {
                    defaultView: {
                        type: 'agendaWeek',
                        duration: { weeks: 1 },
                        buttonText: 'Semaine fixe'
                    }
                },
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
                events: scheduleData,

                selectHelper: true,
                // select: function (start, end, allDay) {
                //     $('#eventModal').modal('show');
                // },

                eventRender: function (event, element, view) {
                    // Ajouter les détails directement à la cellule avec des balises HTML et des styles
                    element.find('.fc-content').html(
                        '<div class="event-details">' +
                        '<div class="detail"><span class="teacher-name">' + event.subject + '</span></div>' +
                        '<div class="detail"><em>' + event.teacher + '</em></div>' +
                        '<div class="detail"><strong>' + event.classroom + '</strong></div>' +

                        '<div class="detail"><span class="event-time">De ' + event.start.format('HH:mm') + ' à ' + event.end.format('HH:mm') + '</span></div>' +
                        '</div>'
                    );

                    // Appliquer des styles aux classes spécifiques
                    element.find('.teacher-name').css('font-size', '18px');
                    element.find('.event-details em').css('font-weight', 'bold');
                    element.find('.event-details strong').css('font - style', 'italic');
                    element.find('.event-time').css('font-weight', 'normal');

                    // Set background color for the entire event
                    element.css('background-color', event.color);
                }
                ,
                eventResize: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;

                    // Récupérer les valeurs des autres champs
                    var teacher = event.teacher;
                    var classe = selectedClass;
                    var subject = event.subject;
                    var classroom = event.classroom;
                    var color = event.color;

                    $.ajax({
                        url: "/setups/schedule/action",
                        type: "POST",
                        data: {
                            title: title,
                            start: start,
                            end: end,
                            id: id,
                            teacher: teacher,
                            class: classe,
                            classroom: classroom,
                            subject: subject,
                            color: color,
                            type: 'update'
                            // Ajouter d'autres champs ici...
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        }
                    });
                },

                eventDrop: function (event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, 'Y-MM-DD HH:mm:ss');
                    var end = $.fullCalendar.formatDate(event.end, 'Y-MM-DD HH:mm:ss');
                    var title = event.title;
                    var id = event.id;

                    // Récupérer les valeurs des autres champs
                    var teacher = event.teacher;
                    var classe = selectedClass;
                    var subject = event.subject
                    var classe = event.class;
                    var classroom = event.classroom;
                    var color = event.color;

                    $.ajax({
                        url: "/setups/schedule/action",
                        type: "POST",
                        data: {
                            classroom: classroom,
                            start: start,
                            end: end,
                            id: id,
                            teacher: teacher,
                            class: classe,
                            classroom: classroom,
                            subject: subject,
                            color: color,
                            type: 'update'
                            // Ajouter d'autres champs ici...
                        },
                        success: function (response) {
                            calendar.fullCalendar('refetchEvents');
                            alert("Event Updated Successfully");
                        },
                        error: function (xhr, status, error) {


                            try {
                                var errorMessage = JSON.parse(xhr.responseText).error;
                                alert("Error: " + errorMessage);
                            } catch (e) {
                                alert("Error saving event. Please try again.");
                            }
                        }
                    });
                },

                eventClick: function (event) {
                    if (confirm("Etes-vous sûre de vouloir supprimer?")) {
                        var id = event.id;

                        // Récupérer les valeurs des autres champs


                        $.ajax({
                            url: "/setups/schedule/action",
                            type: "POST",
                            data: {
                                id: id,

                                type: "delete"
                                // Ajouter d'autres champs ici...
                            },
                            success: function (response) {

                                alert("Emploi du temps supprimé avec success");

                            },
                            error: function (xhr, status, error) {
                                console.error(xhr.responseText);
                                alert("Error deleting event. Please try again.");
                            }
                        });
                    }
                }
            });


            // Handle the Save Event button click
            $('#addEventBtn').on('click', function () {
                // Ouvrir le modal d'ajout d'événement
                $('#eventModal').modal('show');
            });
            $('#saveEventBtn').on('click', function () {


                var teacher = $('#teacherSelected').val();
                var studentclass = selectedClass;
                var subject = $('#subjectSelected').val();
                var classroom = $('#classroomSelected').val();
                var start = $('#startDateTime').val();
                var end = $('#endDateTime').val();
                function getRandomColor() {
                    var letters = '0123456789ABCDEF';
                    var color = '#';
                    for (var i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }
                var color = getRandomColor();

                $.ajax({
                    url: "/setups/schedule/action",
                    type: "POST",
                    data: {

                        start: start,
                        end: end,
                        teacher: teacher,
                        class: studentclass,
                        classroom: classroom,
                        subject: subject,
                        color: color,
                        type: 'add'
                    },
                    success: function (data) {
                        $('#eventModal').modal('hide');
                        calendar.fullCalendar('refetchEvents');
                        alert("Event Created Successfully");
                    },
                    error: function (xhr, status, error) {


                        try {
                            var errorMessage = JSON.parse(xhr.responseText).error;
                            alert("Error: " + errorMessage);
                        } catch (e) {
                            alert("Error saving event. Please try again.");
                        }
                    }
                });
            });


        });


    </script>






</body>

</html>
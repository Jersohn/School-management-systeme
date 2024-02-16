<!DOCTYPE html>
<html lang="fr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />

    <style>
        /* Styles for the sidebar */
        .sidebar {
            width: 100%;
            height: 100%;
            background-color: #f0f0f0;
            float: left;
            padding: 20px;
        }

        /* Styles for the modules */
        .module {
            background-color: #ddd;
            padding: 10px;
            margin-bottom: 10px;
            cursor: pointer;
        }

        /* Styles for FullCalendar */
        #calendar {
            width: 100%;
            height: 600px;
            float: right;
        }
    </style>
</head>

<body class="bg-light">




    <div class="content-wrapper">
        <div class="container-fluid">
            <!-- Content Header (Page header) -->
            <br>

            <h1 class="text-center text-info">Emploi du Temps - {{ $selectedClass}}</h1><br><br>




            <!-- Main content -->
            <section>

                <div class="row">
                    <div class="col-md-3">
                        <div class="sidebar" id="sidebar">
                            <div class="text-dark text-center">
                                <h3>MODULES</h3>
                            </div>
                            <hr>
                            <a href="#" type="button" class="btn btn-rounded btn-outline-info mb-5" id="addEventBtn"><i
                                    class="fa fa-plus"></i>Ajouter un
                                module</a>

                            @php
                            use App\Models\Assign_module;
                            use App\Models\StudentClass;

                            // Récupérer tous les modules et classes

                            $class = $selectedClass;
                            $class_id = StudentClass::where('name',$class)->value('id');
                            $modules = Assign_module::where('class_id',$class_id)->get();

                            @endphp

                            @foreach($modules as $moduleData)

                            <div class="module" id="module{{ $moduleData->id }}" ondragstart="drag(event)"
                                draggable="true" data-id="{{ $moduleData->id }}" data-color="{{ $moduleData->color }}"
                                data-teacher="{{ $moduleData->teacher->name }}"
                                data-subject="{{ $moduleData->subject->name}}"
                                data-classroom="{{ $moduleData->classroom->name }}" style="background-color: {{ $moduleData->color }}; padding: 10px; margin-bottom: 10px;
                            border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" data-toggle="tooltip"
                                title="{{ $moduleData->teacher->name }}">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>{{ $moduleData->subject->name }}</strong>
                                    </div>
                                    <div>
                                        @php
                                        $hoursPerWeek = round($moduleData->hours_per_year / 52, 2);
                                        $hours = floor($hoursPerWeek); // Nombre d'heures entières
                                        $minutes = round(($hoursPerWeek - $hours) * 60);
                                        @endphp


                                        {{ $moduleData->hours_per_year }}h/an <br>

                                        <small>{{ $hours }}h{{ $minutes }}min/semaine</small>
                                    </div>
                                </div>
                                <div style="display: none;">
                                    {{ $moduleData->teacher->name }}
                                </div>
                                <div style="display: none;">
                                    {{ $moduleData->classroom->name }}
                                </div>
                            </div>

                            @endforeach

                            <a href="{{ route('class.view') }}" class="btn btn-rounded btn-outline-info mb-5">
                                Retour
                            </a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div id="calendar"></div>
                    </div>
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
                                    <form id="eventForm" action="{{ route('module.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="class_id">Classe :{{ $selectedClass}}</label>
                                            <input type="hidden" name="class_id" id="classSelected" class="form-control"
                                                value="{{ $selectedClassId}}">
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
                                            <label for="classroom_id">Salle</label>
                                            <select name="classroom_id" id="classroomSelected" class="form-control">
                                                <option value="">Selectionnez une salle</option>
                                                @foreach($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}">{{ $classroom->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save
                                                Event</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </section>


        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment-with-locales.min.js"></script>

    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>

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
                        data.forEach(function (subject) {
                            // Ajouter une option avec le nom de la matière
                            $("#subjectSelected").append(
                                '<option value="' + subject.id + '">' + subject.name + '</option>'
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
        function drag(event) {
            // Récupérer les données du module
            let moduleId = event.target.dataset.id;
            let color = event.target.dataset.color;
            let teacher = event.target.dataset.teacher;
            let subject = event.target.dataset.subject;
            let classroom = event.target.dataset.classroom;

            // Créer un objet de données à transférer
            let eventData = {
                moduleId: moduleId,
                color: color,
                teacher: teacher,
                subject: subject,
                classroom: classroom,
                // Ajoutez d'autres données si nécessaire
            };

            // Stocker les données dans l'événement de glisser-déposer
            event.dataTransfer.setData('text/plain', JSON.stringify(eventData));
        }


        $(document).ready(function () {
            var scheduleData = @json($schedules); // Convertir les données en JSON
            var selectedClass = "{{$selectedClass}}";
            // Fonction pour gérer le début du glisser-déposer

            // Récupérer tous les modules
            let modules = document.querySelectorAll('.module');

            // Boucle sur chaque module
            modules.forEach(module => {
                // Ajouter un gestionnaire d'événements pour le début du glisser-déposer
                module.addEventListener('dragstart', drag);

                // Ajouter un gestionnaire d'événements pour la fin du glisser-déposer
                module.addEventListener('dragend', function (event) {
                    // Réinitialiser les données de l'événement de glisser-déposer
                    event.dataTransfer.clearData();
                });
            });

            // Configuration du calendrier
            $('#calendar').fullCalendar({
                // Autres options du calendrier...
                editable: true,
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                defaultView: 'agendaWeek',
                views: {
                    agendaWeek: {
                        hiddenDays: [0, 6]
                    }
                }
                ,
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
                maxTime: '19:00:00',
                events: scheduleData, // Définissez cette variable dans votre code avec les données d'événements
                selectHelper: true,

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
                    element.find('.event-details strong').css('font-style', 'italic');
                    element.find('.event-time').css('font-weight', 'normal');

                    // Définir la couleur de fond pour l'événement
                    element.css('background-color', event.color);
                },
                eventResize: function (event, delta) {
                    // Code pour le redimensionnement d'événement
                },
                eventDrop: function (event, delta) {
                    // Code pour le déplacement d'événement
                },
                eventClick: function (event) {
                    // Code pour gérer le clic sur un événement
                }
            });

            // Gestionnaire d'événement pour le bouton d'ajout d'événement
            $('#addEventBtn').on('click', function () {
                $('#eventModal').modal('show');
            });

            // Gestionnaire d'événement pour le glisser-déposer sur le calendrier
            $('#calendar').on('drop', function (event) {
                event.preventDefault();
                console.log('dropped');

                let eventData = JSON.parse(event.originalEvent.dataTransfer.getData('text/plain'));
                var teacher = eventData.teacher;
                var studentclass = selectedClass;
                var subject = eventData.subject;
                var classroom = eventData.classroom;

                // Obtenir les coordonnées de l'événement drop
                var droppedDate = $('#calendar').fullCalendar('getDate');
                var view = $('#calendar').fullCalendar('getView');
                var duration = view.intervalEnd.diff(view.intervalStart);
                var droppedTime = Math.floor((event.pageX - $('#calendar').offset().left) / $('#calendar').width() * duration);

                // Calculer la date et l'heure de début et de fin
                var start = moment(droppedDate).add(droppedTime, 'milliseconds');
                var end = moment(start).add(1, 'hour'); // Exemple : ajoute une heure

                var color = eventData.color;

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
                        $('#calendar').fullCalendar('refetchEvents');
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
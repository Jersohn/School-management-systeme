<!DOCTYPE html>
<html lang="fr">

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>Class schedule</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />


    <style>
        /* Styles for the sidebar */
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica Neue, Helvetica, sans-serif;
            font-size: 14px;
        }


        #external-events .fc-event {
            cursor: move;
            margin: 3px 0;
        }



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
                    <div class="col-md-3" id='external-events'>
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
                            @php
                            $hoursPerWeek = round($moduleData->hours_per_year / 52, 2);
                            $hours = floor($hoursPerWeek); // Nombre d'heures entières
                            $minutes = round(($hoursPerWeek - $hours) * 60);
                            @endphp

                            <div class="module fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event"
                                id="module{{ $moduleData->id }}" style="background-color: {{ $moduleData->color }}; padding: 10px; margin-bottom: 10px;
                            border-radius: 8px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" data-toggle="tooltip"
                                title="{{ $moduleData->hours_per_year }}h/an | {{ $hours }}h{{ $minutes }}min/semaine "
                                data-event='{ "subject": "{{ $moduleData->subject->name }}", "teacher": "{{ $moduleData->teacher->name }}", "classroom":"{{ $moduleData->classroom->name }}","color":"{{ $moduleData->color }}" }'>
                                <div class="fc-event-main">
                                    <div style="display: flex; justify-content: space-between; align-items: center;">
                                        <div>
                                            <strong>{{ $moduleData->subject->name }}</strong>
                                        </div>
                                        <div>

                                            {{ $moduleData->teacher->name }}

                                            <br>

                                            <small>{{ $moduleData->classroom->name }}</small>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            @endforeach

                            <a href="{{ route('class.view') }}" class="btn btn-rounded btn-outline-info mb-5">
                                Retour
                            </a>
                        </div>
                    </div>

                    <div class="col-md-9" id='calendar-container'>
                        <div id='calendar'></div>
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
                    <!-- modal modification -->
                    <div class="modal" id="modifyEventModal" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="eventModalLabel">Modification Emploi du Temps</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="eventForm" action="{{ route('module.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="oldclass_id">Classe :{{ $selectedClass}}</label>
                                            <input type="hidden" name="class_id" id="oldclassSelected"
                                                class="form-control" value="{{ $selectedClassId}}">
                                        </div>

                                        <div class="form-group">
                                            <label for="oldteacher_id">Enseignant</label>
                                            <select name="teacher_id" id="oldTeacher" class="form-control">
                                                <option value="">Selectionnez un Enseignant</option>
                                                @foreach($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label for="oldsubject_id">Matière</label>
                                            <select name="subject_id" id="oldsubjectSelected" class="form-control">
                                                <option value="">Sélectionnez une Matière</option>
                                                <!-- Options des matières seront ajoutées ici via JavaScript -->
                                            </select>
                                        </div>


                                        <div class="form-group">
                                            <label for="oldclassroom_id">Salle</label>
                                            <select name="classroom_id" id="oldclassroomSelected" class="form-control">
                                                <option value="">Selectionnez une salle</option>
                                                @foreach($classrooms as $classroom)
                                                <option value="{{ $classroom->id }}">{{ $classroom->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-info">Modifier</button>
                                            <button type="button" class="btn btn-danger">Supprimer</button>
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

        $(document).ready(function () {
            $("#oldTeacher").on("change", function () {
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
                        $("#oldsubjectSelected").empty();
                        // Ajouter les nouvelles options basées sur les matières retournées par la requête AJAX
                        data.forEach(function (subject) {
                            // Ajouter une option avec le nom de la matière
                            $("#oldsubjectSelected").append(
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

        document.addEventListener('DOMContentLoaded', function () {
            var scheduleData = @json($schedules);
            var selectedClass = "{{$selectedClass}}";
            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var containerEl = document.getElementById('sidebar');
            var calendarEl = document.getElementById('calendar');

            // initialize the external events
            // -----------------------------------------------------------------

            new Draggable(containerEl, {
                itemSelector: '.module',
                eventData: function (eventEl) {
                    var eventData = JSON.parse(eventEl.getAttribute('data-event'));
                    var contentHtml =
                        'Matière: ' + eventData.subject + ', ' +
                        'Enseignant: ' + eventData.teacher + ', ' +
                        'Salle: ' + eventData.classroom;

                    return {
                        title: contentHtml,
                        color: eventData.color

                    };
                },


            });



            // initialize the calendar
            // -----------------------------------------------------------------

            var calendar = new Calendar(calendarEl, {

                locale: 'fr',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                buttonText: {
                    today: 'aujourd\'hui'
                },
                initialView: 'timeGridWeek',
                hiddenDays: [0, 7],
                slotMinTime: "07:00",
                slotMaxTime: "19:00",
                editable: true,
                droppable: true,
                events: scheduleData,

                drop: function (info) {

                    // Récupérer les données de l'événement depuis l'attribut data-event de l'élément déplacé
                    var eventData = JSON.parse(info.draggedEl.getAttribute('data-event'));

                    // Récupérer les autres données nécessaires depuis l'événement FullCalendar
                    var start = info.date;
                    var startFormatted = start.toISOString().slice(0, 19).replace('T', ' ');
                    var end = new Date(start.getTime() + 60 * 60 * 1000);
                    var endFormatted = end.toISOString().slice(0, 19).replace('T', ' ');
                    var color = eventData.color;
                    var studentClass = selectedClass;

                    // Envoyer les données via AJAX
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        url: "/setups/schedule/action",
                        type: "POST",
                        headers: {
                            'X-CSRF-TOKEN': csrfToken // Inclure le jeton CSRF dans les en-têtes de la requête
                        },

                        data: {
                            _token: csrfToken,
                            start: startFormatted,
                            end: endFormatted,// Convertir la date en format ISO pour l'envoi
                            teacher: eventData.teacher,
                            class: studentClass, // Assurez-vous que le nom de la propriété correspond au nom utilisé dans le contrôleur
                            classroom: eventData.classroom,
                            subject: eventData.subject,
                            color: color,
                            type: 'add'
                        },
                        success: function (data) {
                            // Traiter la réponse en cas de succès
                            calendar.refetchEvents();

                            alert("Event Created Successfully");
                        },
                        error: function (xhr, status, error) {
                            // Gérer les erreurs
                            try {
                                var errorMessage = JSON.parse(xhr.responseText).error;
                                alert("Error: " + errorMessage);
                            } catch (e) {
                                alert("Error saving event. Please try again.");
                            }
                        }
                    });
                },
                eventClick: function (info) {
                    // Empêche le comportement par défaut du clic sur l'événement
                    info.jsEvent.preventDefault();

                    // Récupère l'URL de l'événement
                    var eventUrl = info.event.url;


                    // Ouvre un nouveau modal pour afficher l'URL de l'événement
                    $('#modifyEventModal').modal('show');
                    // Charge le contenu de l'URL dans le modal (vous pouvez utiliser Ajax ici si nécessaire)
                    $('#modifyEventModal .modal-body').load(eventUrl);
                }








            });


            $('#addEventBtn').on('click', function () {
                $('#eventModal').modal('show');
            });

            calendar.render();
        });

    </script>








</body>

</html>
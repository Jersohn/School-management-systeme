@extends('admin.admin_master')
@section('admin')
use Illuminate\Support\Str;


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="row">



                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title text-primary">Liste des Emplois du temps</h3>
                            <a href="{{ route('class.schedule.add') }}" style="float: right;"
                                class="btn btn-rounded btn-success mb-5"><i class="fa fa-plus"></i>Nouvel emploi du
                                Temps</a>

                        </div>
                        <!-- /.box-header -->

                        <div class="box-body">
                            <ul class="nav nav-pills">
                                @foreach($schedules as $className => $classSchedules)
                                <li class="nav-item">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="tab-{{ Str::slug($className) }}" data-toggle="pill"
                                        href="#{{ Str::slug($className) }}" role="tab"
                                        aria-controls="{{ Str::slug($className) }}"
                                        aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                        {{ $className }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            <hr>

                            <div class="tab-content">
                                @foreach($schedules as $className => $classSchedules)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                                    id="{{ Str::slug($className) }}" role="tabpanel"
                                    aria-labelledby="tab-{{ Str::slug($className) }}">
                                    <h2 style="text-decoration: underline;">Emploi du Temps {{ $className }}</h2>
                                    <small style="float: right;">
                                        <a target="_blank" href="{{ route('class.schedule.pdf', $className) }}">
                                            <i class="fa fa-arrow-right"></i> <i class="fa fa-print"> Imprimer
                                                ici</i>

                                        </a>
                                    </small><br><br>
                                    <!-- Tableau d'emploi du temps spécifique à la classe -->
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Jours</th>
                                                <th>Debut</th>
                                                <th>Fin</th>
                                                <th>Enseignat</th>
                                                <th>Matière</th>
                                                <th>Salle</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($classSchedules as $schedule)
                                            <tr>
                                                <td>{{ $schedule->day_of_week }}</td>
                                                <td>{{ $schedule->start_time }}</td>
                                                <td>{{ $schedule->end_time }}</td>
                                                <td>{{ $schedule->teacher->name }}</td>
                                                <td>{{ $schedule->subject->name }}</td>
                                                <td>{{ $schedule->classroom->name }}</td>
                                                <td>
                                                    <a style="border: none;"
                                                        href="{{ route('class.schedule.edit', $schedule->id) }}"
                                                        class="btn btn-outline"><i class="fa fa-edit"></i></a>

                                                    <a style="border: none;" href="#"
                                                        data-schedule-id="{{ $schedule->id}}"
                                                        class="btn btn-outline delete-btn text-primary">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>

                                        </tfoot>
                                    </table>
                                </div>
                                @endforeach
                            </div>
                        </div>


                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->


                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
</div>

<script>
    // Sélectionnez tous les boutons de suppression
    const deleteButtons = document.querySelectorAll('.delete-btn');

    // Ajoutez un gestionnaire d'événements à chaque bouton de suppression
    deleteButtons.forEach(button => {
        button.addEventListener('click', function (event) {
            event.preventDefault();
            const scheduleId = this.getAttribute('data-schedule-id');

            // Afficher la boîte de dialogue de confirmation SweetAlert2
            Swal.fire({
                title: 'Êtes-vous sûr(e) de vouloir supprimer cet emploi du temps ?',
                text: 'Cette action est irréversible!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirection vers la route de suppression avec l'ID de l'empoi du temps
                    window.location.href = "{{ route('class.schedule.delete', '') }}/" + scheduleId;
                }
            });
        });
    });
</script>



@endsection
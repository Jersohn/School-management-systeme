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
                             <h3 class="box-title">Liste des supports de cours</h3>
                            <a href="{{ route('course.add') }}" style="float:right;"
                                class="btn btn-rounded btn-primary mb-5">
                                <i class="fa fa-plus"></i>Ajouter un cours
                            </a>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom</th>
                                            <th>Classe</th>
                                            <th>Ajouté par</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($courses as $course)
                                        <tr>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->class->name }}</td>
                                            <td>{{ $course->teacher->name }}</td>
                                            <td>
                                                @if ($course->file_path)
                                                <a href="{{ route('display.course', $course->id) }}" target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @else
                                                N/A
                                                @endif

                                                <a style="border: none;" title="Edit"
                                                    href="{{ route('edit.course', $course->id) }}"
                                                    class="btn btn-outline">
                                                    <i class="fa fa-edit"></i></a>



                                                <a style="border: none;" href="#" data-course-id="{{$course->id}}"
                                                    class="btn btn-outline delete-btn">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <!-- Pagination Links -->
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
            const courseId = this.getAttribute('data-course-id');

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
                    window.location.href = "{{ route('delete.course', '') }}/" + courseId;
                }
            });
        });
    });
</script>



@endsection
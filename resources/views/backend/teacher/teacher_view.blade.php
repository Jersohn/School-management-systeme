@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="row">

                <div class="col-12">
                    <div class="box bb-3 border-primary">
                        <div class="box-header">
                            <h4 class="box-title">Rechercher <strong>Enseignant</strong></h4>
                        </div>

                        <div class="box-body">

                            <form method="GET" action="{{ route('teacher.year.wise') }}">

                                <div class="row">



                                    <div class="col-md-4">

                                        <div class="form-group">
                                            <h5>Année <span class="text-danger"> </span></h5>
                                            <div class="controls">
                                                <select name="year_id" required="" class="form-control">
                                                    <option value="" selected="" disabled="">Selectionnez une année</option>
                                                    @foreach($years as $year)
                                                    <option value="{{ $year->id }}" {{ (@$year_id==$year->id)?
                                                        "selected":"" }} >{{ $year->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>

                                    </div> <!-- End Col md 4 -->




                                    <div class="col-md-6">

                                       

                                    </div> <!-- End Col md 4 -->


                                    <div class="col-md-2" style="padding-top: 25px;">

                                        <input type="submit" class="btn btn-rounded btn-dark mb-5" name="search"
                                            value="Search">

                                    </div> <!-- End Col md 4 -->




                                </div><!--  end row -->

                            </form>


                        </div>
                    </div>
                </div> <!-- // end first col 12 -->




                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Liste des Enseignants</h3>
                            <a href="{{ route('teacher.add') }}" style="float: right;"
                                class="btn btn-rounded btn-primary mb-5"> Ajout Enseignant </a>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">

                                @if(!@search)
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">N°</th>
                                            <th>ID</th>
                                            <th>Nom</th>

                                            <th>Email</th>
                                            <th>Matières</th>
                                            <th>Classes</th>
                                            <th>Photo</th>
                                            @if(Auth::user()->role == "Admin")
                                            <th>Code</th>
                                            @endif
                                            <th width="25%">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allData as $key => $value )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td> {{ $value['teacher']['id_no'] }}</td>
                                            <td> {{ $value['teacher']['name'] }}</td>
                                            <td> {{ $value['teacher']['email'] }}</td>

                                            <td>
                                                @foreach(json_decode($value['subject_id']) as $subjectId)
                                                {{ \App\Models\SchoolSubject::find($subjectId)->name }},
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach(json_decode($value['class_id']) as $classId)
                                                {{ \App\Models\StudentClass::find($classId)->name }},
                                                @endforeach
                                            </td>

                                            <td>
                                                <img src="{{ (!empty($value['teacher']['image']))? url('upload/teacher_images/'.$value['teacher']['image']):url('upload/no_image.jpg') }}"
                                                    style="width: 60px; width: 60px;">
                                            </td>
                                            <td>
                                                @if($year = \App\Models\StudentYear::find($value['year_id']))
                                                {{ $year->name }}
                                                @else
                                                <!-- Gérer le cas où $year n'est pas trouvé, par exemple afficher un message d'erreur -->
                                                Error: Invalid year data
                                                @endif
                                            </td>

                                            <td>
                                                <a title="Edit"
                                                    href="{{ route('teacher.edit', ['teacher_id' => $value->teacher_id]) }}"
                                                    class="btn btn-outline-info"> <i class="fa fa-edit"></i></a>



                                                <a target="_blank" title="Details"
                                                    href="{{ route('teacher.details',['teacher_id' => $value->id]) }}"
                                                    class="btn btn-outline-danger"><i class="fa fa-eye"></i></a>

                                                <a href="#" data-teacher-id="{{$value->teacher_id}}"
                                                    class="btn btn-outline-danger delete-btn">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>

                                @else

                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">N°</th>
                                            <th>ID</th>
                                            <th>Nom</th>

                                            <th>Email</th>
                                            <th>Matières</th>
                                            <th>Classes</th>

                                            <th>Photo</th>
                                            @if(Auth::user()->role == "Admin")
                                            <th>Code</th>
                                            @endif
                                            <th width="25%">Action</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allData as $key => $value )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td> {{ $value['teacher']['id_no'] }}</td>
                                            <td> {{ $value['teacher']['name'] }}</td>
                                            <td> {{ $value['teacher']['email'] }}</td>

                                            <td>
                                                @foreach(json_decode($value['subject_id']) as $subjectId)
                                                {{ \App\Models\SchoolSubject::find($subjectId)->name }},
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach(json_decode($value['class_id']) as $classId)
                                                {{ \App\Models\StudentClass::find($classId)->name }},
                                                @endforeach
                                            </td>

                                            <td>
                                                <img src="{{ (!empty($value['teacher']['image']))? url('upload/teacher_images/'.$value['teacher']['image']):url('upload/no_image.jpg') }}"
                                                    style="width: 60px; width: 60px;">
                                            </td>
                                            <td>
                                                {{$value['teacher']['code']}}
                                            </td>

                                            <td>
                                                <a style="border: none;" title="Edit"
                                                    href="{{ route('teacher.edit',['teacher_id' => $value->teacher_id]) }}"
                                                    class="btn btn-outline-info"> <i class="fa fa-edit"></i> </a>



                                                <a style="border: none;" target="_blank" title="Details"
                                                    href="{{ route('teacher.details',['teacher_id' => $value->teacher_id]) }}"
                                                    class="btn btn-outline-danger"><i class="fa fa-eye"></i></a>


                                                <a style="border: none;" href="#"
                                                    data-teacher-id="{{ $value->teacher_id }}"
                                                    class="btn btn-outline-danger delete-btn text-primary">
                                                    <i class="fa fa-trash"></i>
                                                </a>

                                            </td>

                                        </tr>
                                        @endforeach

                                    </tbody>
                                    <tfoot>

                                    </tfoot>
                                </table>


                                @endif



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
            const teacherId = this.getAttribute('data-teacher-id');

            // Afficher la boîte de dialogue de confirmation SweetAlert2
            Swal.fire({
                title: 'Êtes-vous sûr(e) de vouloir supprimer cet enseignant ?',
                text: 'Cette action est irréversible!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer!',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Redirection vers la route de suppression avec l'ID de l'étudiant
                    window.location.href = "{{ route('teacher.delete', '') }}/" + teacherId;
                }
            });
        });
    });
</script>

@endsection
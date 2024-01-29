@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title text-primary"> <i class="fa fa-plus"></i> Ajout d'un nouvel emploi du temps
                    </h4>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">

                            <form action="{{ route('class.schedule.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="class_id">Classe</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Selectionnez la classe</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="teacher_id">Enseignant</label>
                                    <select name="teacher_id" id="teacher_id" class="form-control">
                                        <option value="">Selectionnez un Enseignant</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subject_id">Matière</label>
                                    <select name="subject_id" id="subject_id" class="form-control">
                                        <option value="">Selectionnez une Matière</option>
                                        @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">
                                            {{ $subject->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_time">Debut</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="end_time">Fin</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="day_of_week">Jour de la semaine</label>
                                    <select name="day_of_week" id="day_of_week" class="form-control">
                                        <option value="Lundi">Lundi</option>
                                        <option value="Mardi">Mardi</option>
                                        <option value="Mercredi">Mercredi</option>
                                        <option value="Jeudi">Jeudi</option>
                                        <option value="Vendredi">Vendredi</option>
                                        <option value="Samedi">Samedi</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="classroom_id">Salle</label>
                                    <select name="classroom_id" id="classroom_id" class="form-control">
                                        <option value="">Selectionnez une salle</option>
                                        @foreach($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Soumettre">
                                </div>
                            </form>


                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>





    </div>
</div>




@endsection
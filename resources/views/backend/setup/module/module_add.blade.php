@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Add Module</h4>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">
                            <form action="{{ route('module.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="subject_id">Matière :</label>
                                    <select name="subject_id" id="subject_id" class="form-control">
                                        <option value="" selected="" disabled="">Selectionnez une matière
                                        </option>
                                        @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="teacher_id">Enseignant :</label>
                                    <select name="teacher_id" id="teacher_id" class="form-control">
                                        <option value="" selected="" disabled="">Selectionnez un enseignant
                                        </option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="class_id">Classe :</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="" selected="" disabled="">Selectionnez une classe
                                        </option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="classroom_id">Salle de classe :</label>
                                    <select name="classroom_id" id="classroom_id" class="form-control">
                                        <option value="" selected="" disabled="">Selectionnez une salle
                                        </option>
                                        @foreach($classrooms as $classroom)
                                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                                        @endforeach
                                    </select>
                                </div>



                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Ajouter">
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
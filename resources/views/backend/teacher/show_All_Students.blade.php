@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="row">





                <div class="col-12">

                    <div class="box">
                        <div class="box-header with-border">
                            <h3 class="box-title">Liste des Etudiants</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">N°</th>
                                            <th>Nom</th>
                                            <th>ID No</th>
                                            <th>Email</th>

                                            <th>Classe</th>
                                            <th>Image</th>


                                            <th width="25%">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentTaught as $key => $student)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ optional($student->student)->name }}</td>
                                            <td>{{ optional($student->student)->id_no }}</td>
                                            <td>{{ optional($student->student)->email }}</td>
                                            <td>{{ optional($student->student_class)->name }}</td>
                                            <td>
                                                <img src="{{ (!empty(optional($student->student)->image)) ? url('upload/student_images/' . optional($student->student)->image) : url('upload/no_image.jpg') }}"
                                                    style="width: 60px; height: 60px;">
                                            </td>
                                            <td>
                                                <a style="border: none;" title="message"
                                                    href="mailto:{{ optional($student->student)->email }}"
                                                    class="btn btn-outline-primary"><i class="fa fa-envelope"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>


                                    <tfoot>

                                    </tfoot>
                                </table>




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




@endsection
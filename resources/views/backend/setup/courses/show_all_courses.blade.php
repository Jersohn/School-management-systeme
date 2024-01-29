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
                            <h3 class="box-title">Support de cours</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nom du cours</th>
                                            <th>Classe</th>
                                            <th>Ajouté par</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentCourse as $course)
                                        <tr>
                                            <td>{{ $course->name }}</td>
                                            <td>{{ $course->class->name }}</td>
                                            <td>{{ $course->teacher->name }}</td>
                                            <td>
                                                @if ($course->file_path)
                                                <a href="{{ route('display.AdminCourse', $course->id) }}"
                                                    target="_blank">
                                                    <i class="fa fa-eye"></i>
                                                    <i class="fa fa-eye"></i>
                                                </a>

                                                @else
                                                N/A
                                                @endif


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




@endsection
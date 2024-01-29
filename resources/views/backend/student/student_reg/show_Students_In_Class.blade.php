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
                            <h3 class="box-title">Student List</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL</th>
                                            <th>Name</th>
                                            <th>ID No</th>
                                            <th>Email</th>

                                            <th>Class</th>
                                            <th>Image</th>


                                            <th width="25%">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($studentList as $key => $value )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td> {{ $value['student']['name'] }}</td>
                                            <td> {{ $value['student']['id_no'] }}</td>
                                            <td> {{ $value['student']['email']}} </td>

                                            <td> {{ $value['student_class']['name'] }}</td>
                                            <td>
                                                <img src="{{ (!empty($value['student']['image']))? url('upload/student_images/'.$value['student']['image']):url('upload/no_image.jpg') }}"
                                                    style="width: 60px; width: 60px;">
                                            </td>

                                            <td>

                                                <a style="border: none;" title="message"
                                                    href="mailto: {{ $value['student']['email']}}"
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
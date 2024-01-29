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
                            <h3 class="box-title">Teacher List</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL</th>
                                            <th>Name</th>
                                            <th>Subjects</th>

                                            <th>Email</th>


                                            <th>Image</th>


                                            <th width="25%">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($teacherList as $key => $value )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td> {{ $value['teacher']['name'] }}</td>
                                            <td> @foreach(json_decode($value['subject_id']) as $subjectId)
                                                {{ \App\Models\SchoolSubject::find($subjectId)->name }},
                                                @endforeach</td>

                                            <td> {{ $value['teacher']['email']}} </td>


                                            <td>
                                                <img src="{{ (!empty($value['teacher']['image']))? url('upload/teacher_images/'.$value['teacher']['image']):url('upload/no_image.jpg') }}"
                                                    style="width: 60px; width: 60px;">
                                            </td>

                                            <td>

                                                <a style="border: none;" title="message"
                                                    href="mailto: {{ $value['teacher']['email']}}"
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
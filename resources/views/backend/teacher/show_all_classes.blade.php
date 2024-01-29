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
                            <h3 class="box-title">Liste des Classes</h3>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">


                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">N°</th>
                                            <th>Nom</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(json_decode($classesTaught[0]) as $key => $classId)
                                        @php
                                        $classIdInt = (int)$classId;
                                        $studentClass = \App\Models\StudentClass::find($classIdInt);
                                        $className = $studentClass ? $studentClass->name : 'Class Not Found';
                                        @endphp

                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $className }}</td>
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
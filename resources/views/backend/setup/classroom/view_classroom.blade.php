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
                            <h3 class="box-title">Liste des Salles de classe</h3>
                            <a href="{{ route('school.classroom.add') }}" style="float: right;"
                                class="btn btn-rounded btn-success mb-5"> Ajouter une Salle</a>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">N°</th>
                                            <th>Nom</th>
                                            <th width="25%">Actions</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allData as $key => $classroom )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td> {{ $classroom->name }}</td>
                                            <td>
                                                <a style="border: none;"
                                                    href="{{ route('school.classroom.edit',$classroom->id) }}"
                                                    class="btn btn-outline-info"><i class="fa fa-edit"></i></a>
                                                <a style="border: none;"
                                                    href="{{ route('school.classroom.delete',$classroom->id) }}"
                                                    class="btn btn-outline-danger" id="delete"><i
                                                        class="fa fa-trash"></i></a>

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
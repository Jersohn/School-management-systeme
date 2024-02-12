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
                            <h3 class="box-title">Liste des Modules</h3>
                            <a href="{{ route('module.add') }}" style="float: right;"
                                class="btn btn-rounded btn-success mb-5"> Ajout module</a>

                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="table-responsive">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%">SL</th>
                                            <th>Nom du module</th>
                                            <th>Nom de la classe</th>
                                            <th>Volume horaire par an</th>
                                            <th>Enseignant(s)</th>
                                            <th>Salle</th>
                                            <th>Couleur</th>
                                            <th width="25%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assignModules as $key => $assignModule)
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $assignModule->subject->name }}</td>
                                            <td>{{ $assignModule->studentClass->name }}</td>
                                            <td>{{ $assignModule->hours_per_year }}</td>
                                            <td>{{ $assignModule->teacher->name }}</td>

                                            <td>{{ $assignModule->classroom->name }}</td>
                                            <td>{{ $assignModule->color }}</td>
                                            <td>
                                                <a href="{{ route('module.edit', $assignModule->id) }}"
                                                    class="btn btn-info"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('module.delete', $assignModule->id) }}"
                                                    class="btn btn-danger" id="delete"><i class="fa fa-trash"></i></a>
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
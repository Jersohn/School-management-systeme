@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">

            <div class="row justify-content-center">

                <div class="card bg-white">
                    <div class="card-header">
                        <h2 class="text-dark">Volumes Horaires
                        </h2>
                        <a href="{{ route('planning.add') }}" style="float: right;"
                            class="btn btn-rounded btn-primary mb-5"> Ajout horaire</a>
                    </div>

                    <div class="card-body" style="overflow-x: auto;">
                        <table class="table table-bordered table-striped">

                            <thead style="background-color: darkgrey;">
                                <tr>
                                    <th scope="col"></th>
                                    @foreach($subjects as $subject)
                                    <th scope="col" class="text-dark">{{ $subject->name }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php $even = false; @endphp
                                @foreach($classes as $class)
                                <tr class="{{ $even ? 'even-row' : 'odd-row' }} text-dark">
                                    <td style="background-color: darkgrey;">{{ $class->name }}</td>

                                    @foreach($subjects as $subject)
                                    <td>
                                        @php
                                        $planning = $plannings->where('class_id', $class->id)->where('subject_id',
                                        $subject->id)->first();
                                        $hours = $planning ? $planning->hours : '';
                                        @endphp
                                        <span
                                            class="badge {{ $hours < 10 ? 'badge-success' : ($hours < 20 ? 'badge-warning' : 'badge-danger') }}">{{
                                            $hours }}</span>
                                    </td>
                                    @endforeach
                                    <td style="background-color: darkgrey;">
                                        <!-- Colonne pour le bouton de modification -->
                                        <a href="{{ route('planning.edit', $class->id) }}"
                                            class="btn btn-sm btn-primary"> <i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                                @php $even = !$even; @endphp
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>

            </div>
        </section>
        <!-- /.content -->

    </div>
</div>





@endsection
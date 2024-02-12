@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper light-body">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card bg-white">
                        <div class="card-header">
                            <h2 class="text-primary">Modification des volume horaires </h2>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('planning.update', $classId) }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="class">Classe :</label>
                                    <select name="class" id="class" class="form-control">
                                        <option value="{{ $classId }}">{{ $classe }}</option>
                                    </select>
                                </div>

                                @foreach($planning as $plan)
                                <div class="form-group">
                                    <label for="hours_{{ $plan->subject_id }}">{{ $plan->subject->name }}</label>
                                    <input type="number" name="hours_{{ $plan->subject_id }}"
                                        id="hours_{{ $plan->subject_id }}" class="form-control"
                                        value="{{ $plan->hours }}" min="0">
                                </div>
                                @endforeach

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Soumettre">
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->

    </div>
</div>





@endsection
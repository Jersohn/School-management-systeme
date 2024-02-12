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
                            <h2 class="text-primary">Créer un planning</h2>
                        </div>

                        <div class="card-body">
                            <form action="{{ route('planning.store') }}" method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="student_class">Classe :</label>
                                    <select name="student_class" id="student_class" class="form-control text-primary">
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                @foreach($subjects as $subject)
                                <div class="form-group">
                                    <label for="hours_{{ $subject->id }}">{{ $subject->name }}</label>
                                    <input type="number" name="hours_{{ $subject->id }}" id="hours_{{ $subject->id }}"
                                        class="form-control text-primary"
                                        placeholder="Volume horaire pour {{ $subject->name }}" min="0">
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
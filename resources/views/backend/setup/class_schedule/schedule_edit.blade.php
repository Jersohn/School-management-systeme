@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title text-primary"><i class="fa fa-edit"></i> </a>Edit Class Shedule</h4>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">

                            <form action="{{ route('class.schedule.update', $schedule->id) }}" method="POST">
                                @csrf


                                <div class="form-group">
                                    <label for="class_id">Class</label>
                                    <select name="class_id" id="class_id" class="form-control">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}" {{ $class->id == $schedule->class_id ?
                                            'selected' : '' }}>
                                            {{ $class->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="teacher_id">Teacher</label>
                                    <select name="teacher_id" id="teacher_id" class="form-control">
                                        <option value="">Select Teacher</option>
                                        @foreach($teachers as $teacher)
                                        <option value="{{ $teacher->id }}" {{ $teacher->id == $schedule->teacher_id ?
                                            'selected' : '' }}>
                                            {{ $teacher->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="subject_id">Subject</label>
                                    <select name="subject_id" id="subject_id" class="form-control">
                                        <option value="">Select Subject</option>
                                        @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" {{ $subject->id == $schedule->subject_id ?
                                            'selected' : '' }}>
                                            {{ $subject->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="classroom_id">Classroom</label>
                                    <select name="classroom_id" id="classroom_id" class="form-control">
                                        <option value="">Select Classroom</option>
                                        @foreach($classrooms as $classroom)
                                        @php
                                        $existingSchedule = \App\Models\ClassSchedule::where('day_of_week',
                                        $schedule->day_of_week)
                                        ->where('start_time', '<', $schedule->end_time)
                                            ->where('end_time', '>', $schedule->start_time)
                                            ->where('classroom_id', $classroom->id)
                                            ->where('id', '!=', $schedule->id)
                                            ->exists();
                                            @endphp
                                            <option value="{{ $classroom->id }}" {{ $classroom->id ==
                                                $schedule->classroom_id ? 'selected' : '' }}
                                                {{ $existingSchedule ? 'disabled' : '' }}>
                                                {{ $classroom->name }}
                                            </option>
                                            @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="day_of_week">Day of the Week</label>
                                    <select name="day_of_week" id="day_of_week" class="form-control">
                                        <option value="Lundi" {{ $schedule->day_of_week == 'Lundi' ? 'selected' : ''
                                            }}>Lundi</option>
                                        <option value="Mardi" {{ $schedule->day_of_week == 'Mardi' ? 'selected' : ''
                                            }}>Mardi</option>
                                        <option value="Mercredi" {{ $schedule->day_of_week == 'Mercredi' ? 'selected'
                                            : '' }}>Mercredi</option>
                                        <option value="Jeudi" {{ $schedule->day_of_week == 'Jeudi' ? 'selected' :
                                            '' }}>Jeudi</option>
                                        <option value="Vendredi" {{ $schedule->day_of_week == 'Vendredi' ? 'selected' : ''
                                            }}>Vendredi</option>
                                        <option value="Samedi" {{ $schedule->day_of_week == 'Samedi' ? 'selected' :
                                            '' }}>Samedi</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="start_time">Start Time</label>
                                    <input type="time" name="start_time" id="start_time" class="form-control"
                                        value="{{ $schedule->start_time }}">
                                </div>

                                <div class="form-group">
                                    <label for="end_time">End Time</label>
                                    <input type="time" name="end_time" id="end_time" class="form-control"
                                        value="{{ $schedule->end_time }}">
                                </div>

                                <!-- Champ masqué pour l'ID de l'emploi du temps -->
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Update">
                                </div>
                            </form>


                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->

        </section>





    </div>
</div>





@endsection
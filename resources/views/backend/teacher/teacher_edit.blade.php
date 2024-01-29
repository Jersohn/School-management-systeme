@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <section class="content">

            <!-- Basic Forms -->
            <div class="box">
                <div class="box-header with-border">
                    <h4 class="box-title">Edit Teacher </h4>

                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">

                            <form method="post" action="{{ route('update.teacher',$editData['teacher']['id']) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">



                                        <div class="row"> <!-- 1st Row -->

                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <h5>Name <span class="text-danger">*</span></h5>

                                                    <div class="controls">
                                                        <input type="text" name="name" class="form-control"
                                                            value="{{$editData['teacher']['name']}}">
                                                    </div>
                                                </div>

                                            </div> <!-- End Col md 4 -->


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Email<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control"
                                                            value="{{$editData['teacher']['email']}}">
                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Mobile Number <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="mobile" class="form-control"
                                                            value="{{$editData['teacher']['mobile']}}">
                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->


                                        </div> <!-- End 1stRow -->






                                        <div class="row"> <!-- 2nd Row -->

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Address <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="address" class="form-control"
                                                            value="{{$editData['teacher']['address']}}">
                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Courses <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        @php
                                                        $assignedSubjectsArray = json_decode($assignedSubjects[0],
                                                        true);
                                                        @endphp

                                                        <select name="subjects[]" id="subjects" multiple="multiple">
                                                            <option value="" selected disabled>Select Subject</option>
                                                            @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}" {{ in_array((string)
                                                                $subject->id, $assignedSubjectsArray) ? 'selected' : ''
                                                                }}>
                                                                {{ $subject->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>




                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->




                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Classes <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        @php
                                                        $assignedClassesArray = json_decode($assignedClasses[0], true);
                                                        @endphp

                                                        <select name="classes[]" id="classes" multiple="multiple">
                                                            <option value="" selected disabled>Select Class</option>
                                                            @foreach($classes as $class)
                                                            <option value="{{ $class->id }}" {{ in_array((string)
                                                                $class->id, $assignedClassesArray) ? 'selected' : '' }}>
                                                                {{ $class->name }}
                                                            </option>
                                                            @endforeach
                                                        </select>


                                                    </div>
                                                </div>
                                            </div> <!-- End Col md 4 -->


                                        </div> <!-- End 2nd Row -->










                                        <div class="row"> <!-- 3rd Row -->

                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <h5>Year <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select name="year_id" required="" class="form-control">
                                                            <option value="" selected="" disabled="">Select Year
                                                            </option>
                                                            @foreach($years as $year)
                                                            <option value="{{ $year->id }}" {{ ($editData->year_id ==
                                                                $year->id)? "selected":"" }} >{{ $year->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Profile Image <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="file" name="image" class="form-control" id="image">
                                                    </div>
                                                </div>
                                            </div> <!-- End Col md 4 -->




                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <img id="showImage"
                                                            src="{{ (!empty($editData['teacher']['image']))? url('upload/teacher_images/'.$editData['teacher']['image']):url('upload/no_image.jpg') }}"
                                                            style="width: 100px; width: 100px; border: 1px solid #000000;">

                                                    </div>
                                                </div>


                                            </div>



                                        </div> <!-- End 3rd Row -->












                                        <div class="text-xs-right">
                                            <input type="submit" class="btn btn-rounded btn-info mb-5" value="Update  ">
                                        </div>
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

<script type="text/javascript">
    $(document).ready(function () {
        $('#image').change(function (e) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#showImage').attr('src', e.target.result);
            }
            reader.readAsDataURL(e.target.files['0']);
        });
    });
</script>



@endsection
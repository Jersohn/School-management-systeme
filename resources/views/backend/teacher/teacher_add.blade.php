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
                    					<h2 class="box-title text-primary"> <i class="fa fa-plus"></i> Ajout d'un enseignant </h2>


                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="row">
                        <div class="col">

                            <form method="post" action="{{ route('store.teacher') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12">



                                        <div class="row"> <!-- 1st Row -->

                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <h5>Nom <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="name" class="form-control" required="">
                                                    </div>
                                                </div>

                                            </div> <!-- End Col md 4 -->


                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Email<span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="email" name="email" class="form-control"
                                                            required="">
                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Contact <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="mobile" class="form-control"
                                                            required="">
                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->


                                        </div> <!-- End 1stRow -->






                                        <div class="row"> <!-- 2nd Row -->

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Adresse <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="text" name="address" class="form-control"
                                                            required="">
                                                    </div>
                                                </div>



                                            </div> <!-- End Col md 4 -->



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Matières <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select name="subjects[]" id="subjects" multiple="multiple">
                                                            @foreach($subjects as $subject)
                                                            <option value="{{ $subject->id }}">{{ $subject->name }}
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
                                                        <select name="classes[]" id="classes" multiple="multiple">
                                                            @foreach($classes as $class)
                                                            <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div> <!-- End Col md 4 -->


                                        </div> <!-- End 2nd Row -->










                                        <div class="row"> <!-- 3rd Row -->
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5>Sexe <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select name="gender" id="gender" required=""
                                                            class="form-control">
                                                            <option value="" selected="" disabled="">Select Gender
                                                            </option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="col-md-4">

                                                <div class="form-group">
                                                    <h5>Année <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <select name="year_id" required="" class="form-control">
                                                            <option value="" selected="" disabled="">Selectionnez une année
                                                            </option>
                                                            @foreach($years as $year)
                                                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>

                                            </div>



                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <h5> Photo de Profile <span class="text-danger">*</span></h5>
                                                    <div class="controls">
                                                        <input type="file" name="image" class="form-control" id="image">
                                                    </div>
                                                </div>
                                            </div> <!-- End Col md 4 -->




                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <div class="controls">
                                                        <img id="showImage" src="{{ url('upload/no_image.jpg') }}"
                                                            style="width: 100px; width: 100px; border: 1px solid #000000;">

                                                    </div>
                                                </div>

                                            </div>


                                        </div> <!-- End 3rd Row -->












                                        <div class="text-xs-right">
                                            <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Soumettre">
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
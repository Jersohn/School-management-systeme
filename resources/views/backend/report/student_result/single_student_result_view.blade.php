@extends('admin.admin_master')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <div class="content-wrapper">
            <div class="container-full">
                <!-- Content Header (Page header) -->
                

                <!-- Main content -->
                <section class="content">
                <div class="row">

                
        <div class="col-12">
        <div class="box bb-3 border-primary">
                        <div class="box-header">
            <h4 class="box-title"><strong>Student Result</strong></h4>
                        </div>

                        <div class="box-body">
                        
        <form method="GET" action="{{ route('single.student.result.view')}}" target="_blank">
                    @csrf
                    <div class="row">



        <div class="col-md-3">

                <div class="form-group">
                <h5>Year <span class="text-danger"> </span></h5>
                <div class="controls">
            <select id="year_id"  class="form-control">
                    <option value="" selected="" disabled="">{{$year_name}}</option>
                    
                    
                </select>
            </div>		 
            </div>
            
                    </div> <!-- End Col md 3 --> 



                    
                <div class="col-md-3">

                <div class="form-group">
                <h5>Class <span class="text-danger"> </span></h5>
                <div class="controls">
            <select id="class_id"  class="form-control">
                    <option value="" selected="" disabled="">{{$student_class}}</option>
                    
                    
                </select>
            </div>		 
            </div>
            
                    </div> <!-- End Col md 3 --> 


                


        <div class="col-md-3">

                <div class="form-group">
                <h5>Exam Type <span class="text-danger"> </span></h5>
                <div class="controls">
        <select name="exam_type_id" id="exam_type_id"  required="" class="form-control">
                    <option value="" selected="" disabled="">Select Class</option>
                    @foreach($exam_type as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                    @endforeach
                    
                </select>
            </div>		 
            </div>
            
                    </div> <!-- End Col md 3 --> 

        


                    <div class="col-md-3" style="padding-top: 25px;"  >
                    <input type="hidden" name="student_year_id" id="" value="{{$student_year_id}}">
                    <input type="hidden" name="student_id" id="" value="{{$studentId}}">

        <input type="submit" class="btn btn-rounded btn-primary" value="Search">

            
                    </div> <!-- End Col md 3 --> 		
                    </div><!--  end row --> 

        

                </form> 

                        
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                </section>
                <!-- /.content -->
            
            </div>
        </div>

        

 


@endsection

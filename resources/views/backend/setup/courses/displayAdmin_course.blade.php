@extends('admin.admin_master')
@section('admin')
use Illuminate\Support\Str;


<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="row">




                <div class="container">

                    @if ($course->file_path)
                    <iframe src="{{ asset($course->file_path) }}" style="width: 100%; height: 100vh;"></iframe>
                    @else
                    N/A
                    @endif

                </div>


            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->

    </div>
</div>





@endsection
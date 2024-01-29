@extends('admin.admin_master')
@section('admin')

<div class="content-wrapper">
	<div class="container-full">

		<!-- Main content -->
		@if(Auth::user()->usertype === 'Admin')
		<section class="content">
			<div class="row">
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-primary-light rounded w-60 h-60">
								<i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary">Total Utilisateur <span
										class="text-white mb-0 font-weight-500"> | {{ $numbUser }} </span></h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-warning-light rounded w-60 h-60">
								<i class="text-warning mr-0 font-size-24 mdi mdi-account-star"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary">Administrateurs <span
										class="text-white mb-0 font-weight-500">| {{ $numbAdmin }} </span></h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-info-light rounded w-60 h-60">
								<i class="text-info mr-0 font-size-24 mdi mdi-school"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary">Enseignants <span
										class="text-white mb-0 font-weight-500"> | {{ $numbTeacher }} </span></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-danger-light rounded w-60 h-60">
								<i class="text-danger mr-0 font-size-24 mdi mdi-school"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary">Etudiants <span
										class="text-white mb-0 font-weight-500"> | {{ $numbStudent }} </span></h2>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		@endif
		@if(Auth::user()->usertype === 'Student')
		<section class="content">
			<div class="row">
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-primary-light rounded w-60 h-60">
								<i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('show.class.student', ['student_id' => Auth::id()]) }}">Total
										Etudiants</a> <span class="text-white mb-0 font-weight-500">|
										{{$numbStudentsInClass}}</span></h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-warning-light rounded w-60 h-60">
								<i class="text-warning mr-0 font-size-24 mdi mdi-account-star"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('show.class.teachers', ['student_id' => Auth::id()]) }}">Total
										Enseignants </a><span class="text-white mb-0 font-weight-500">
										| {{$numTeachersInClass}}</span></h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-info-light rounded w-60 h-60">
								<i class="text-info mr-0 font-size-24 mdi mdi-school"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('show.class.subjects', ['student_id' => Auth::id()]) }}">
										Matières</a> <span class="text-white mb-0 font-weight-500">
										| {{$numSubjectsInClass}}</span></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-danger-light rounded w-60 h-60">
								<i class="text-danger mr-0 font-size-24 mdi mdi-book"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('student.schedule.view', ['student_id' => Auth::id()]) }}">
										<i class="ti-eye"></i> Emploi du temps
									</a> <span class="text-white mb-0 font-weight-500"> </span></h2>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		@endif
		@if(Auth::user()->usertype === 'Teacher')
		<section class="content">
			<div class="row">
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-primary-light rounded w-60 h-60">
								<i class="text-primary mr-0 font-size-24 mdi mdi-account-multiple"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('students.show', ['teacher_id' => Auth::id()]) }}">Total
										Etudiants</a> <span class="text-white mb-0 font-weight-500"> |
										{{$numStudentsInClasses}}</span></h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-warning-light rounded w-60 h-60">
								<i class="text-warning mr-0 font-size-24 mdi mdi-account-star"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('classes.show', ['teacher_id' => Auth::id()]) }}">Total
										Classes</a><span class="text-white mb-0 font-weight-500"> |
										{{$numClassesTaught}}
									</span></h2>

							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-info-light rounded w-60 h-60">
								<i class="text-info mr-0 font-size-24 mdi mdi-school"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('subjects.show', ['teacher_id' => Auth::id()]) }}">Total
										Matières</a> <span class="text-white mb-0 font-weight-500"> |
										{{$numSubjectsHandled}}</span></h2>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-3 col-6">
					<div class="box overflow-hidden pull-up">
						<div class="box-body">
							<div class="icon bg-danger-light rounded w-60 h-60">
								<i class="text-danger mr-0 font-size-24 mdi mdi-book"></i>
							</div>
							<div>
								<h2 class="text-mute mt-20 mb-0 font-size-16 text-primary"><a
										href="{{ route('teacher.schedule.view', ['teacher_id' => Auth::id()]) }}">
										<i class="ti-eye"></i> Emploi du temps
									</a><span class="text-white mb-0 font-weight-500"> </span></h2>

							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		@endif


		<!-- /.content -->
	</div>
</div>

@endsection
@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
	<div class="container-full">
		<!-- Content Header (Page header) -->


		<!-- Main content -->
		<section class="content">
			<div class="row">

				<div class="col-12">
					<div class="box bb-3 border-primary">
						<div class="box-header">
							<h4 class="box-title">Recherche <strong>Etudiants</strong></h4>
						</div>

						<div class="box-body">

							<form method="GET" action="{{ route('student.year.class.wise') }}">

								<div class="row">



									<div class="col-md-4">

										<div class="form-group">
											<h5>Année <span class="text-danger"> </span></h5>
											<div class="controls">
												<select name="year_id" required="" class="form-control">
													<option value="" selected="" disabled="">Selectionnez une année
													</option>
													@foreach($years as $year)
													<option value="{{ $year->id }}" {{ (@$year_id==$year->id)?
														"selected":"" }} >{{ $year->name }}</option>
													@endforeach

												</select>
											</div>
										</div>

									</div> <!-- End Col md 4 -->




									<div class="col-md-4">

										<div class="form-group">
											<h5>Classe <span class="text-danger"> </span></h5>
											<div class="controls">
												<select name="class_id" required="" class="form-control">
													<option value="" selected="" disabled="">Selectionnez une classe
													</option>
													@foreach($classes as $class)
													<option value="{{ $class->id }}" {{ (@$class_id==$class->id)?
														"selected":"" }}>{{ $class->name }}</option>
													@endforeach

												</select>
											</div>
										</div>

									</div> <!-- End Col md 4 -->


									<div class="col-md-4" style="padding-top: 25px;">

										<input type="submit" class="btn btn-rounded btn-dark mb-5" name="search"
											value="Recherche">

									</div> <!-- End Col md 4 -->




								</div><!--  end row -->

							</form>


						</div>
					</div>
				</div> <!-- // end first col 12 -->




				<div class="col-12">

					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Liste des Etudiants</h3>
							<a href="{{ route('student.registration.add') }}" style="float: right;"
								class="btn btn-rounded btn-primary mb-5"> Ajouter un etudiant </a>

						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">

								@if(!@search)
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="5%">N°</th>
											<th>Nom</th>
											<th>Matricule</th>
											<th>Email</th>
											<th>Année</th>
											<th>Classe</th>
											<th>Photo</th>
											@if(Auth::user()->role == "Admin")
											<th>Code</th>
											@endif
											<th width="25%">Actions</th>

										</tr>
									</thead>
									<tbody>
										@foreach($allData as $key => $value )
										<tr>
											<td>{{ $key+1 }}</td>
											<td> {{ $value['student']['name'] }}</td>
											<td> { { $value['student']['id_no'] }}</td>
											<td> {{ $value['student']['email']}} </td>
											<td> {{ $value['student_year']['name'] }}</td>
											<td> {{ $value['student_class']['name'] }}</td>
											<td>
												<img src="{{ (!empty($value['student']['image']))? url('upload/student_images/'.$value['student']['image']):url('upload/no_image.jpg') }}"
													style="width: 60px; width: 60px;">
											</td>
											<td> {{ $value['student']['code']}}</td>
											<td>
												<a style="border: none;" title="Edit"
													href="{{ route('student.registration.edit',$value->student_id) }}"
													class="btn btn-outline-info"> <i class="fa fa-edit"></i> </a>

												<a style="border: none;" title="Promotion"
													href="{{ route('student.registration.promotion',$value->student_id) }}"
													class="btn btn-outline-primary"><i class="fa fa-check"></i></a>

												<a style="border: none;" target="_blank" title="Details"
													href="{{ route('student.registration.details',$value->student_id) }}"
													class="btn btn-danger"><i class="fa fa-eye"></i></a>
												<a style="border: none;" href="#"
													data-student-id="{{ $value->student_id }}"
													class="btn btn-outline-danger delete-btn text-primary">
													<i class="fa fa-trash"></i>
												</a>
												<a style="border: none;" title="message"
													href="mailto: {{ $value['student']['email']}}"
													class="btn btn-outline-primary"><i class="fa fa-message"></i></a>



											</td>

										</tr>
										@endforeach
										<a href="{{ route('student.print.list') }}"> <i class="fa fa-print"></i>
										</a>

									</tbody>
									<tfoot>

									</tfoot>
								</table>

								@else

								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="5%">N°</th>
											<th>Nom</th>
											<th>Matricule</th>
											<th>Email</th>
											<th>Année</th>
											<th>Classe</th>
											<th>Photo</th>
											@if(Auth::user()->role == "Admin")
											<th>Code</th>
											@endif
											<th width="25%">Actions</th>

										</tr>
									</thead>
									<tbody>
										@foreach($allData as $key => $value )
										<tr>
											<td>{{ $key+1 }}</td>
											<td> {{ $value['student']['name'] }}</td>
											<td> {{ $value['student']['id_no'] }}</td>
											<td> {{ $value['student']['email']}} </td>
											<td> {{ $value['student_year']['name'] }}</td>
											<td> {{ $value['student_class']['name'] }}</td>
											<td>
												<img src="{{ (!empty($value['student']['image']))? url('upload/student_images/'.$value['student']['image']):url('upload/no_image.jpg') }}"
													style="width: 60px; width: 60px;">
											</td>
											<td> {{ $value['student']['code']}}</td>
											<td>
												<a style="border: none;" title="Edit"
													href="{{ route('student.registration.edit',$value->student_id) }}"
													class="btn btn-outline-info"> <i class="fa fa-edit"></i> </a>

												<a style="border: none;" title="Promotion"
													href="{{ route('student.registration.promotion',$value->student_id) }}"
													class="btn btn-outline-primary"><i class="fa fa-check"></i></a>

												<a style="border: none;" target="_blank" title="Details"
													href="{{ route('student.registration.details',$value->student_id) }}"
													class="btn btn-outline-success"><i class="fa fa-eye"></i></a>
												<a style="border: none;" href="#"
													data-student-id="{{ $value->student_id }}"
													class="btn btn-outline-danger delete-btn">
													<i class="fa fa-trash"></i>
												</a>
												<a style="border: none;" title="message"
													href="mailto: {{ $value['student']['email']}}"
													class="btn btn-outline-primary"><i class="fa fa-envelope"></i></a>

											</td>


										</tr>
										@endforeach

									</tbody>
									<tfoot>

									</tfoot>
									<div>
										<a href="{{ route('student.print.list') }}" style="float:right"
											class="btn btn-outline"> <i class="fa fa-print"></i> imprimer
											liste </a>
									</div>
								</table>


								@endif



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



<script>
	// Sélectionnez tous les boutons de suppression
	const deleteButtons = document.querySelectorAll('.delete-btn');

	// Ajoutez un gestionnaire d'événements à chaque bouton de suppression
	deleteButtons.forEach(button => {
		button.addEventListener('click', function (event) {
			event.preventDefault();
			const studentId = this.getAttribute('data-student-id');

			// Afficher la boîte de dialogue de confirmation SweetAlert2
			Swal.fire({
				title: 'Êtes-vous sûr(e) de vouloir supprimer cet étudiant ?',
				text: 'Cette action est irréversible!',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#d33',
				cancelButtonColor: '#3085d6',
				confirmButtonText: 'Oui, supprimer!',
				cancelButtonText: 'Annuler'
			}).then((result) => {
				if (result.isConfirmed) {
					// Redirection vers la route de suppression avec l'ID de l'étudiant
					window.location.href = "{{ route('student.registration.delete', '') }}/" + studentId;
				}
			});
		});
	});
</script>

@endsection
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
					<h2 class="box-title text-primary"> <i class="fa fa-plus"></i> Ajout d'un étudiant </h2>

				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col">

							<form method="post" action="{{ route('store.student.registration') }}"
								enctype="multipart/form-data">
								@csrf
								<div class="row">
									<div class="col-12">



										<div class="row"> <!-- 1st Row -->

											<div class="col-md-4">

												<div class="form-group">
													<h5>Nom de l'étudiant <span class="text-danger">*</span></h5>
													<div class="controls">
														<input type="text" name="name" class="form-control" required="">
													</div>
												</div>

											</div> <!-- End Col md 4 -->


											<div class="col-md-4">

												<div class="form-group">
													<h5>Nom du père <span class="text-danger">*</span></h5>
													<div class="controls">
														<input type="text" name="fname" class="form-control"
															required="">
													</div>
												</div>

											</div> <!-- End Col md 4 -->



											<div class="col-md-4">

												<div class="form-group">
													<h5>Nom de la mère <span class="text-danger">*</span></h5>
													<div class="controls">
														<input type="text" name="mname" class="form-control"
															required="">
													</div>
												</div>

											</div> <!-- End Col md 4 -->


										</div> <!-- End 1stRow -->






										<div class="row"> <!-- 2nd Row -->

											<div class="col-md-4">

												<div class="form-group">
													<h5>Contact <span class="text-danger">*</span></h5>
													<div class="controls">
														<input type="text" name="mobile" class="form-control"
															required="">
													</div>
												</div>

											</div> <!-- End Col md 4 -->


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
													<h5>Sexe <span class="text-danger">*</span></h5>
													<div class="controls">
														<select name="gender" id="gender" required=""
															class="form-control">
															<option value="" selected="" disabled="">Selectionnez un sexe
															</option>
															<option value="Male">Masculin</option>
															<option value="Female">Feminin</option>

														</select>
													</div>
												</div>

											</div> <!-- End Col md 4 -->


										</div> <!-- End 2nd Row -->



										<div class="row"> <!-- 3rd Row -->


											<div class="col-md-4">

												<div class="form-group">
													<h5>Religion <span class="text-danger">*</span></h5>
													<div class="controls">
														<select name="religion" id="religion" required=""
															class="form-control">
															<option value="" selected="" disabled="">Selectionnez une Religion
															</option>
															<option value="Islam">Islam</option>
															<option value="Hindu">Hindu</option>
															<option value="Christan">Christianisme</option>
															<option value="Christan">Bouddhisme</option>

														</select>
													</div>
												</div>

											</div> <!-- End Col md 4 -->




											<div class="col-md-4">

												<div class="form-group">
													<h5>Date de naissance <span class="text-danger">*</span></h5>
													<div class="controls">
														<input type="date" name="dob" class="form-control" required="">
													</div>
												</div>

											</div> <!-- End Col md 4 -->


											<div class="col-md-4">

												<div class="form-group">
													<h5>Reduction <span class="text-danger">*</span></h5>
													<div class="controls">
														<input type="text" name="discount" class="form-control"
															required="">
													</div>
												</div>

											</div> <!-- End Col md 4 -->


										</div> <!-- End 3rd Row -->




										<div class="row"> <!-- 4TH Row -->


											<div class="col-md-4">

												<div class="form-group">
													<h5>Année scolaire <span class="text-danger">*</span></h5>
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

											</div> <!-- End Col md 4 -->




											<div class="col-md-4">

												<div class="form-group">
													<h5>Classe <span class="text-danger">*</span></h5>
													<div class="controls">
														<select name="class_id" required="" class="form-control">
															<option value="" selected="" disabled="">Selectionnez une Classe
															</option>
															@foreach($classes as $class)
															<option value="{{ $class->id }}">{{ $class->name }}</option>
															@endforeach

														</select>
													</div>
												</div>

											</div> <!-- End Col md 4 -->


											<div class="col-md-4">

												<div class="form-group">
													<h5>Group <span class="text-danger">*</span></h5>
													<div class="controls">
														<select name="group_id" required="" class="form-control">
															<option value="" selected="" disabled="">Selectionnez un Groupe
															</option>
															@foreach($groups as $group)
															<option value="{{ $group->id }}">{{ $group->name }}</option>
															@endforeach

														</select>
													</div>
												</div>

											</div> <!-- End Col md 4 -->


										</div> <!-- End 4TH Row -->




										<div class="row"> <!-- 5TH Row -->


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
													<h5>Photo de profile <span class="text-danger">*</span></h5>
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

											</div> <!-- End Col md 4 -->


										</div> <!-- End 5TH Row -->




										<div class="text-xs-right">
											<input type="submit" class="btn btn-rounded btn-primary mb-5" value="Submit">
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
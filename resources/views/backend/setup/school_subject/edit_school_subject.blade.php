@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
	<div class="container-full">
		<!-- Content Header (Page header) -->


		<section class="content">

			<!-- Basic Forms -->
			<div class="box">
				<div class="box-header with-border">
					<h4 class="box-title">Modification de Matière</h4>

				</div>
				<!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col">

							<form method="post" action="{{ route('update.school.subject',$editData->id) }}">
								@csrf
								<div class="row">
									<div class="col-12">




										<div class="form-group">
											<h5>Nom de la matière <span class="text-danger">*</span></h5>
											<div class="controls">
												<input type="text" name="name" class="form-control"
													value="{{ $editData->name }}">
												@error('name')
												<span class="text-danger">{{ $message }}</span>
												@enderror
											</div>

										</div>




										<div class="text-xs-right">
											<input type="submit" class="btn btn-rounded btn-info mb-5" value="Modifier">
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
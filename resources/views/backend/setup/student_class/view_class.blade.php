@extends('admin.admin_master')
@section('admin')


<div class="content-wrapper">
	<div class="container-full">
		<!-- Content Header (Page header) -->


		<!-- Main content -->
		<section class="content">
			<div class="row">



				<div class="col-12">

					<div class="box">
						<div class="box-header with-border">
							<h3 class="box-title">Liste des Classes</h3>
							<a href="{{ route('student.class.add') }}" style="float: right;"
								class="btn btn-rounded btn-success mb-5"> Ajouter une classe</a>

						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="5%">N°</th>
											<th>Nom</th>
											<th width="25%">Action</th>

										</tr>
									</thead>
									<tbody>
										@foreach($allData as $key => $student )
										<tr>
											<td>{{ $key+1 }}</td>
											<td> {{ $student->name }}</td>
											<td>
												<a style="border:none"
													href="{{ route('student.class.edit',$student->id) }}"
													class="btn btn-outline-info"><i class="fa fa-edit"></i></a>
												<a style="border:none"
													href="{{ route('student.class.delete',$student->id) }}"
													class="btn btn-outline-danger text-primary" id="delete"><i
														class="fa fa-trash"></i></a>

											</td>

										</tr>
										@endforeach

									</tbody>
									<tfoot>

									</tfoot>
								</table>
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





@endsection
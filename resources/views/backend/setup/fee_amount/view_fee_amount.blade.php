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
							<h3 class="box-title">Liste des Categories de frais scolaire</h3>
							<a href="{{ route('fee.amount.add') }}" style="float: right;"
								class="btn btn-rounded btn-success mb-5"> Ajouter frais de scolarité</a>

						</div>
						<!-- /.box-header -->
						<div class="box-body">
							<div class="table-responsive">
								<table id="example1" class="table table-bordered table-striped">
									<thead>
										<tr>
											<th width="5%">N°</th>
											<th>Categorie</th>
											<th width="25%">Action</th>

										</tr>
									</thead>
									<tbody>
										@foreach($allData as $key => $amount )
										<tr>
											<td>{{ $key+1 }}</td>
											<td> {{ $amount['fee_cateogry']['name'] }}</td>
											<td>
												<a href="{{ route('fee.amount.edit',$amount->fee_category_id) }}"
													class="btn btn-outline-info"><i class="fa fa-edit"></i></a>
												<a href="{{ route('fee.amount.details',$amount->fee_category_id) }}"
													class="btn btn-outline-primary">Details</a>

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
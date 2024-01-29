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
							<h3 class="box-title"> Details de Frais scolaire</h3>
							<a href="{{ route('fee.amount.add') }}" style="float: right;"
								class="btn btn-rounded btn-success mb-5"> Ajouter une Categorie de frais</a>

						</div>
						<!-- /.box-header -->
						<div class="box-body">

							<h4><strong>Categorie de Frais : </strong>{{ $detailsData['0']['fee_cateogry']['name'] }}
							</h4>
							<div class="table-responsive">
								<table class="table table-bordered table-striped">
									<thead class="thead-light">
										<tr>
											<th width="5%">N°</th>
											<th>Classe</th>
											<th width="25%">Montant</th>

										</tr>
									</thead>
									<tbody>
										@foreach($detailsData as $key => $detail )
										<tr>
											<td>{{ $key+1 }}</td>
											<td> {{ $detail['student_class']['name'] }}</td>
											<td> {{ $detail->amount }}</td>

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
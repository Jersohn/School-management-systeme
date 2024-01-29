@extends('admin.admin_master')
@section('admin')

<div class="content-wrapper">
    <div class="container-full">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-6 box bb-3 border-primary">

                        <div class="box-header">
                            <h4 class="box-title">Paiement des Frais de Scolarité</strong></h4>
                        </div>

                        <div class="box-body">

                            <form
                                action="{{ route('payment.store', ['class_id' => $details['student_class']['id'], 'student_id' => $details['student']['id']]) }}"
                                method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="amount">Entrer le montant</label>
                                    <input type="number" class="form-control" id="amount" name="amount" required>
                                </div>

                                <div class="form-group">
                                    <label for="payment_method">Méthode de paiement</label>
                                    <select class="form-control" id="payment_method" name="payment_method" required>
                                        <option value="credit_card">Carte de crédit</option>
                                        <option value="bank_transfer">Virement bancaire</option>
                                        <option value="cash">Espèces</option>
                                    </select>
                                </div>

                                <div class="text-xs-right">
                                    <input type="submit" class="btn btn-rounded btn-primary mb-5" value="Valider">
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


        </section>
        <!-- /.content -->


    </div>
</div>
<br>
<br>
<hr>






@endsection
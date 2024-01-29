<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\StudentPayment;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;
use App\Models\FeeCategoryAmount;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;

use DB;
use PDF;


class RegistrationFeeController extends Controller
{
	public function RegFeeView()
	{
		$data['years'] = StudentYear::all();
		$data['classes'] = StudentClass::all();
		return view('backend.student.registration_fee.registration_fee_view', $data);
	}



	public function RegFeeClassData(Request $request)
	{
		$year_id = $request->year_id;
		$class_id = $request->class_id;
		if ($year_id != '') {
			$where[] = ['year_id', 'like', $year_id . '%'];
		}
		if ($class_id != '') {
			$where[] = ['class_id', 'like', $class_id . '%'];
		}
		$allStudent = AssignStudent::with(['discount'])->where($where)->get();
		// dd($allStudent);
		$html['thsource'] = '<th>SL</th>';
		$html['thsource'] .= '<th>ID No</th>';
		$html['thsource'] .= '<th>Nom</th>';

		$html['thsource'] .= '<th>Frais</th>';
		$html['thsource'] .= '<th>Reduction </th>';
		$html['thsource'] .= '<th>Frais a payer </th>';
		$html['thsource'] .= '<th>payé </th>';
		$html['thsource'] .= '<th>reste a payer </th>';
		$html['thsource'] .= '<th>Action</th>';


		foreach ($allStudent as $key => $v) {
			$registrationfee = FeeCategoryAmount::where('fee_category_id', '2')->where('class_id', $v->class_id)->first();
			$amountPaid = StudentPayment::where('class_id', $v->class_id)->where('student_id', $v->student_id)->sum('amount');

			$color = 'success';
			$html[$key]['tdsource'] = '<td>' . ($key + 1) . '</td>';
			$html[$key]['tdsource'] .= '<td>' . $v['student']['id_no'] . '</td>';
			$html[$key]['tdsource'] .= '<td>' . $v['student']['name'] . '</td>';

			$html[$key]['tdsource'] .= '<td>' . $registrationfee->amount . '$' . '</td>';
			$html[$key]['tdsource'] .= '<td>' . $v['discount']['discount'] . '%' . '</td>';

			$originalfee = $registrationfee->amount;
			$discount = $v['discount']['discount'];
			$discounttablefee = $discount / 100 * $originalfee;
			$finalfee = (float) $originalfee - (float) $discounttablefee;
			$remainingFees = $finalfee - (float) $amountPaid;

			$html[$key]['tdsource'] .= '<td>' . $finalfee . '$' . '</td>';
			$html[$key]['tdsource'] .= '<td>' . $amountPaid . '$' . '</td>';
			$html[$key]['tdsource'] .= '<td>' . $remainingFees . '$' . '</td>';
			$html[$key]['tdsource'] .= '<td>';
			$html[$key]['tdsource'] .= '<a class="btn btn-sm btn-' . $color . '" title="paiement" target="_blanks" href="' . route("payment.process") . '?class_id=' . $v->class_id . '&student_id=' . $v->student_id . '">paiement</a>';
			$html[$key]['tdsource'] .= '</td>';
			$html[$key]['tdsource'] .= '<td>';
			$html[$key]['tdsource'] .= '<a class="btn btn-sm btn-' . $color . '" title="Historique" target="_blanks" href="' . route("student.registration.fee.payslip") . '?class_id=' . $v->class_id . '&student_id=' . $v->student_id . '">Détails</a>';
			$html[$key]['tdsource'] .= '</td>';

		}
		return response()->json(@$html);

	} // end method 

	public function PayFees(Request $request)
	{
		$student_id = $request->student_id;

		$class_id = $request->class_id;


		$student['details'] = AssignStudent::with(['student', 'discount'])->where('student_id', $student_id)->where('class_id', $class_id)->first();

		return view('backend.student.registration_fee.registration_fee_pay', $student);

	}

	public function PaymentProcessStore(Request $request, $class_id, $student_id)
	{

		// Validation rules, adjust as needed
		$validatedData = $request->validate([

			'amount' => 'required|numeric',
			'payment_method' => 'required|string',
			// Add other validation rules as needed
		]);

		// Create a new student payment record
		$student_payment = new StudentPayment();
		$student_payment->student_id = $student_id;

		$student_payment->class_id = $class_id;
		$student_payment->amount = $request->amount;
		$student_payment->payment_method = $request->payment_method;
		$student_payment->save();

		$notification = [
			'message' => 'Payment recorded successfully',
			'alert-type' => 'success',
		];

		// You can add a success message or redirect the user to another page
		return redirect()->route('registration.fee.view')->with($notification);
	}





	public function RegFeePayslip(Request $request)
	{
		$student_id = $request->student_id;
		$class_id = $request->class_id;

		$details = AssignStudent::with(['student', 'discount'])
			->where('student_id', $student_id)
			->where('class_id', $class_id)
			->first();

		$paymentHistory = StudentPayment::where('student_id', $student_id)
			->where('class_id', $class_id)
			->get();


		$pdf = PDF::loadView('backend.student.registration_fee.registration_fee_pdf', compact('details', 'paymentHistory'));
		$pdf->SetProtection(['copy', 'print'], '', 'pass');
		return $pdf->stream('document.pdf');
	}





}

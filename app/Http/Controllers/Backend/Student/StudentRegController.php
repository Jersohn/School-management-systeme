<?php

namespace App\Http\Controllers\Backend\Student;

use App\Http\Controllers\Controller;
use App\Models\FeeCategoryAmount;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;

// use DB;
use Illuminate\Support\Facades\DB;
use niklasravnsborg\LaravelPdf\Facades\Pdf as FacadesPdf;

use PDF;
use Illuminate\Support\Facades\Session;



class StudentRegController extends Controller
{
	public function StudentRegView()
	{
		$data['years'] = StudentYear::all();
		$data['classes'] = StudentClass::all();

		$data['year_id'] = StudentYear::orderBy('id', 'desc')->first()->id;
		$data['class_id'] = StudentClass::orderBy('id', 'desc')->first()->id;
		// dd($data['class_id']);
		$data['allData'] = AssignStudent::where('year_id', $data['year_id'])->where('class_id', $data['class_id'])->get();
		return view('backend.student.student_reg.student_view', $data);

	}

	public function StudentClassYearWise(Request $request)
	{
		$data['years'] = StudentYear::all();
		$data['classes'] = StudentClass::all();

		$data['year_id'] = $request->year_id;
		$data['class_id'] = $request->class_id;
		$storedData = AssignStudent::where('year_id', $request->year_id)
			->where('class_id', $request->class_id)
			->get();

		$data['allData'] = $storedData;
		session()->put('storedData', $storedData);


		return view('backend.student.student_reg.student_view', $data);


	}

	public function StudentList()
	{
		$storedData = '';

		$storedSession = session()->get('storedData');
		if ($storedSession == null) {
			// Display an error message and prompt the user to select a year and class
			$notification = array(
				'message' => 'Veillez selectionner une classe et une année svp !',
				'alert-type' => 'warning'
			);

			return redirect()->route('student.registration.view')->with($notification);


		} else {
			$storedData = $storedSession;
			$pdf = PDF::loadView('backend.student.student_reg.student_list', ['allData' => $storedData]);
			$pdf->SetProtection(['copy', 'print'], '', 'pass');
			return $pdf->stream('document.pdf');
		}
	}




	public function StudentRegAdd()
	{
		$data['years'] = StudentYear::all();
		$data['classes'] = StudentClass::all();
		$data['groups'] = StudentGroup::all();

		return view('backend.student.student_reg.student_add', $data);
	}


	public function StudentRegStore(Request $request)
	{
		DB::transaction(function () use ($request) {
			$checkYear = StudentYear::find($request->year_id)->name;
			$student = User::where('usertype', 'Student')->orderBy('id', 'DESC')->first();

			if ($student == null) {
				$firstReg = 0;
				$studentId = $firstReg + 1;
				if ($studentId < 10) {
					$id_no = '000' . $studentId;
				} elseif ($studentId < 100) {
					$id_no = '00' . $studentId;
				} elseif ($studentId < 1000) {
					$id_no = '0' . $studentId;
				}
			} else {
				$student = User::where('usertype', 'Student')->orderBy('id', 'DESC')->first()->id;
				$studentId = $student + 1;
				if ($studentId < 10) {
					$id_no = '000' . $studentId;
				} elseif ($studentId < 100) {
					$id_no = '00' . $studentId;
				} elseif ($studentId < 1000) {
					$id_no = '0' . $studentId;
				}

			} // end else 

			$final_id_no = $checkYear . $id_no;
			$user = new User();
			$code = rand(0000, 9999);
			$user->id_no = $final_id_no;
			$user->password = bcrypt($code);
			$user->usertype = 'Student';
			$user->code = $code;
			$user->name = $request->name;
			$user->fname = $request->fname;
			$user->mname = $request->mname;
			$user->mobile = $request->mobile;
			$user->address = $request->address;
			$user->gender = $request->gender;
			$user->email = $request->email;
			$user->religion = $request->religion;
			$user->dob = date('Y-m-d', strtotime($request->dob));

			if ($request->file('image')) {
				$file = $request->file('image');
				$filename = date('YmdHi') . $file->getClientOriginalName();
				$file->move(public_path('upload/student_images'), $filename);
				$user['image'] = $filename;
			}
			$user->save();

			$assign_student = new AssignStudent();
			$assign_student->student_id = $user->id;
			$assign_student->year_id = $request->year_id;
			$assign_student->class_id = $request->class_id;
			$assign_student->group_id = $request->group_id;

			$assign_student->save();

			$studentClassId = $request->class_id;
			$studentAmount = FeeCategoryAmount::where('fee_category_id', '2')->where('class_id', $studentClassId)->value('amount');


			$discount_student = new DiscountStudent();
			$discount_student->assign_student_id = $assign_student->id;
			$discount_student->fee_category_id = '1';
			$discount_student->discount = $request->discount;

			// Convert $studentAmount to float before calculating the total fees

			$discountResult = $request->discount / 100 * $studentAmount;
			$finalFees = (float) $studentAmount - (float) $discountResult;
			$discount_student->final_fees = $finalFees;
			$discount_student->save();


		});


		$notification = array(
			'message' => 'Student Registration Inserted Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('student.registration.view')->with($notification);

	} // End Method 



	public function StudentRegEdit($student_id)
	{
		$data['years'] = StudentYear::all();
		$data['classes'] = StudentClass::all();
		$data['groups'] = StudentGroup::all();


		$data['editData'] = AssignStudent::with(['student', 'discount'])->where('student_id', $student_id)->first();
		// dd($data['editData']->toArray());
		return view('backend.student.student_reg.student_edit', $data);

	}




	public function StudentRegUpdate(Request $request, $student_id)
	{
		DB::transaction(function () use ($request, $student_id) {



			$user = User::where('id', $student_id)->first();
			$user->name = $request->name;
			$user->fname = $request->fname;
			$user->mname = $request->mname;
			$user->mobile = $request->mobile;
			$user->address = $request->address;
			$user->gender = $request->gender;
			$user->religion = $request->religion;
			$user->email = $request->email;
			$user->dob = date('Y-m-d', strtotime($request->dob));

			if ($request->file('image')) {
				$file = $request->file('image');
				@unlink(public_path('upload/student_images/' . $user->image));
				$filename = date('YmdHi') . $file->getClientOriginalName();
				$file->move(public_path('upload/student_images'), $filename);
				$user['image'] = $filename;
			}
			$user->save();

			$assign_student = AssignStudent::where('id', $request->id)->where('student_id', $student_id)->first();

			$assign_student->year_id = $request->year_id;
			$assign_student->class_id = $request->class_id;
			$assign_student->group_id = $request->group_id;
			$assign_student->shift_id = $request->shift_id;
			$assign_student->save();

			$discount_student = DiscountStudent::where('assign_student_id', $request->id)->first();

			$discount_student->discount = $request->discount;
			$discount_student->save();

		});


		$notification = array(
			'message' => 'Student Registration Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('student.registration.view')->with($notification);

	} // End Method 


	public function StudentRegPromotion($student_id)
	{
		$data['years'] = StudentYear::all();
		$data['classes'] = StudentClass::all();
		$data['groups'] = StudentGroup::all();


		$data['editData'] = AssignStudent::with(['student', 'discount'])->where('student_id', $student_id)->first();

		return view('backend.student.student_reg.student_promotion', $data);

	}




	public function StudentUpdatePromotion(Request $request, $student_id)
	{
		DB::transaction(function () use ($request, $student_id) {



			$user = User::where('id', $student_id)->first();
			$user->name = $request->name;
			$user->fname = $request->fname;
			$user->mname = $request->mname;
			$user->mobile = $request->mobile;
			$user->address = $request->address;
			$user->gender = $request->gender;
			$user->religion = $request->religion;
			$user->email = $request->email;
			$user->dob = date('Y-m-d', strtotime($request->dob));

			if ($request->file('image')) {
				$file = $request->file('image');
				@unlink(public_path('upload/student_images/' . $user->image));
				$filename = date('YmdHi') . $file->getClientOriginalName();
				$file->move(public_path('upload/student_images'), $filename);
				$user['image'] = $filename;
			}
			$user->save();

			$assign_student = new AssignStudent();

			$assign_student->student_id = $student_id;
			$assign_student->year_id = $request->year_id;
			$assign_student->class_id = $request->class_id;
			$assign_student->group_id = $request->group_id;

			$assign_student->save();

			$discount_student = new DiscountStudent();

			$discount_student->assign_student_id = $assign_student->id;
			$discount_student->fee_category_id = '1';
			$discount_student->discount = $request->discount;
			$discount_student->save();

		});


		$notification = array(
			'message' => 'Student Promotion Updated Successfully',
			'alert-type' => 'success'
		);

		return redirect()->route('student.registration.view')->with($notification);

	} // End Method 



	public function StudentRegDetails($student_id)
	{
		$data['details'] = AssignStudent::with(['student', 'discount'])->where('student_id', $student_id)->first();

		$pdf = FacadesPdf::loadView('backend.student.student_reg.student_details_pdf', $data);
		$pdf->SetProtection(['copy', 'print'], '', 'pass');
		return $pdf->stream('document.pdf');

	}
	public function StudentRegDelete($student_id)
	{
		// Vérifier si l'étudiant existe dans la table 'assign_students'
		$assign_student = DB::table('assign_students')->where('student_id', $student_id)->first();

		if ($assign_student) {
			// Récupérer l'ID 'assign_student_id'
			$assign_student_id = $assign_student->id;

			// Supprimer les enregistrements dans la table 'discount_students' liés à 'assign_students'
			DB::table('discount_students')->where('assign_student_id', $assign_student_id)->delete();

			// Supprimer l'enregistrement 'assign_students' de l'étudiant
			DB::table('assign_students')->where('student_id', $student_id)->delete();

			// Supprimer l'utilisateur dans la table 'users'
			User::where('id', $student_id)->delete();

			// Retourner à la page précédente avec un message de succès
			$notification = [
				'message' => 'Student deleted Successfully',
				'alert-type' => 'info'
			];
			return redirect()->back()->with($notification);
		} else {
			// Si l'étudiant n'est pas trouvé dans 'assign_students', retourner avec un message d'erreur
			$notification = [
				'message' => 'Student not found in assign_students table',
				'alert-type' => 'error'
			];
			return redirect()->back()->with($notification);
		}
	}




}

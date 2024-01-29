<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ClassSchedule;
use App\Models\SchoolSubject;
use Illuminate\Http\Request;
use App\Models\AssignStudent;
use App\Models\User;
use App\Models\DiscountStudent;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\StudentGroup;
use App\Models\StudentShift;
use DB;
use PDF;

use App\Models\AssignSubject;
use App\Models\AssignTeacher;
use App\Models\StudentMarks;
use App\Models\ExamType;
use Illuminate\Support\Facades\Auth;

class DefaultController extends Controller
{



	public function GetStudents(Request $request)
	{
		$year_id = $request->year_id;
		$class_id = $request->class_id;
		$allData = AssignStudent::with(['student'])->where('year_id', $year_id)->where('class_id', $class_id)->get();
		return response()->json($allData);

	}
	public function index()
	{
		$classId = null; // Initialize $classId variable
		$numTeachers = 0;
		$numSubjects = 0;
		$numStudent = 0;
		$numClasses = 0;
		$numTeacherSubject = 0;

		if (Auth::user()->usertype === 'Student') {
			$assignedStudent = AssignStudent::where('student_id', Auth::user()->id)->first();

			if ($assignedStudent) {
				// Check if the student is assigned to a class
				$classId = $assignedStudent->class_id;

				// Count number of teachers teaching this class


				// Count number of teachers teaching these classes
				$desiredValue = strval($classId); // Replace this with the value you want to search for in the JSON array
				$desiredValueJson = json_encode($desiredValue); // Convert the value to a JSON string

				$assignedTeachers = AssignTeacher::whereRaw('JSON_CONTAINS(class_id, ?)', [$desiredValueJson])->get();
				$numTeachers = count($assignedTeachers);







				// Get subjects associated with this class
				$numSubjects = ClassSchedule::where('class_id', $classId)->distinct('subject_id')->count('subject_id');

			}
			$data = [

				'numbStudentsInClass' => ($classId !== null) ? AssignStudent::where('class_id', $classId)->count() : 0,
				'numTeachersInClass' => $numTeachers,
				'numSubjectsInClass' => $numSubjects,
				// If $classId is null, set numbStudentsInClass to 0
			];
		} elseif (Auth::user()->usertype === 'Teacher') {
			$teacherId = Auth::user()->id;

			// Count the number of classes taught by the teacher
			$classesTaught = AssignTeacher::where('teacher_id', $teacherId)->pluck('class_id');

			$decodedClasses = $classesTaught->map(function ($item) {
				return json_decode($item, true);
			})->collapse()->unique();

			$numClassesTaught = $decodedClasses->count();


			$SubjectsHandled = AssignTeacher::where('teacher_id', $teacherId)->pluck('subject_id');
			$decodedSubject = $SubjectsHandled->map(function ($item) {
				return json_decode($item, true);
			})->collapse()->unique();

			$numSubjectsHandled = $decodedSubject->count();



			// Count the number of students in classes taught by the teacher
			$classesTaughtByTeacher = AssignTeacher::where('teacher_id', $teacherId)->pluck('class_id')->first();
			$decodedClasses = json_decode($classesTaughtByTeacher, true);

			// Count the number of students in classes taught by the teacher
			$numStudentsInClasses = AssignStudent::whereIn('class_id', $decodedClasses)->count();




			$data = [
				'numClassesTaught' => $numClassesTaught,
				'numSubjectsHandled' => $numSubjectsHandled,
				'numStudentsInClasses' => $numStudentsInClasses,
				// Add other teacher-specific data to the $data array
			];






		} else {
			$data = [
				'numbAdmin' => User::where('usertype', 'Admin')->count(),
				'numbStudent' => User::where('usertype', 'Student')->count(),
				'numbTeacher' => User::where('usertype', 'Teacher')->count(),
				'numbUser' => User::count(),

			];

		}
		$notification = [
    'message' => 'Bienvenue sur votre back office',
    'alert-type' => 'success',
      ];

return view('admin.index', $data)->with('notification', $notification);

}

	public function ShowStdentInClass($student_id)
	{
		$assignedStudent = AssignStudent::where('student_id', $student_id)->first();
		$classId = $assignedStudent->class_id;
		$studentList = ($classId !== null) ? AssignStudent::where('class_id', $classId)->get() : 0;


		return view('backend.student.student_reg.show_Students_In_Class', ['studentList' => $studentList]);


	}
	public function ShowTeacherInClass($student_id)
	{
		$assignedStudent = AssignStudent::where('student_id', $student_id)->first();
		$classId = $assignedStudent->class_id;
		$desiredValue = strval($classId); // Replace this with the value you want to search for in the JSON array
		$desiredValueJson = json_encode($desiredValue); // Convert the value to a JSON string

		$teacherList = AssignTeacher::whereRaw('JSON_CONTAINS(class_id, ?)', [$desiredValueJson])->get();



		return view('backend.student.student_reg.show_Teachers_In_Class', ['teacherList' => $teacherList]);


	}
	public function ShowClassSubject($student_id)
	{
		$assignedStudent = AssignStudent::where('student_id', $student_id)->first();
		$classId = $assignedStudent->class_id;
		$subjectList = ClassSchedule::where('class_id', $classId)->get();


		return view('backend.student.student_reg.show_Students_Subject', ['subjectList' => $subjectList]);


	}

	//Teacher Default Dashboard panel content
	public function ShowTeacherStudent($teacherId)
	{
		$classesTaughtByTeacher = AssignTeacher::where('teacher_id', $teacherId)->pluck('class_id')->first();
		$decodedClasses = json_decode($classesTaughtByTeacher, true);

		// Count the number of students in classes taught by the teacher
		$studentTaught = AssignStudent::whereIn('class_id', $decodedClasses)->get();


		return view('backend.teacher.show_All_Students', ['studentTaught' => $studentTaught]);


	}
	public function ShowTeacherClasses($teacherId)
	{
		$classesTaught = AssignTeacher::where('teacher_id', $teacherId)->pluck('class_id');
		$decodedClasses = $classesTaught ? json_decode($classesTaught, true) : [];





		return view('backend.teacher.show_all_classes', ['classesTaught' => $decodedClasses]);


	}
	public function ShowTeacherSubjects($teacherId)
	{
		$SubjectsHandled = AssignTeacher::where('teacher_id', $teacherId)->pluck('subject_id');
		$decodedSubject = $SubjectsHandled ? json_decode($SubjectsHandled, true) : [];




		return view('backend.teacher.show_all_subjects', ['subjectsTaught' => $decodedSubject]);


	}
	public function DisplayTeacherSubjects($teacherId)
	{
		// Fetch subjects based on the teacher ID
		$subjectsHandled = AssignTeacher::where('teacher_id', $teacherId)->pluck('subject_id')->first();

		// If subjects are stored as JSON in the database
		$decodedSubjects = $subjectsHandled ? json_decode($subjectsHandled, true) : [];

		// Fetch subjects from the Subject model using the decoded subject IDs
		$subjects = SchoolSubject::whereIn('id', $decodedSubjects)->pluck('name', 'id')->toArray();

		return $subjects;
	}






}

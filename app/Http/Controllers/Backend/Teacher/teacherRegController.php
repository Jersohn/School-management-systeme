<?php

namespace App\Http\Controllers\Backend\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AssignTeacher;
use Illuminate\Http\Request;

use App\Models\StudentYear;
use App\Models\StudentClass;
use App\Models\SchoolSubject;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use niklasravnsborg\LaravelPdf\Facades\Pdf as FacadesPdf;

class teacherRegController extends Controller
{
    public function TeacherView()
    {

        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['subjects'] = SchoolSubject::all();
        $data['year_id'] = StudentYear::orderBy('id', 'desc')->first()->id;
        $data['class_id'] = StudentClass::orderBy('id', 'desc')->first()->id;
        $data['subject_id'] = SchoolSubject::orderBy('id', 'desc')->first()->id;
        $data['allData'] = AssignTeacher::with('teacher')->where('year_id', $data['year_id'])
            ->get();

        return view('backend.teacher.teacher_view', $data);
    }
    public function TeacherYearWise(Request $request)
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = SchoolSubject::all();
        $data['subjects'] = SchoolSubject::all();

        $data['year_id'] = $request->year_id;
        $data['class_id'] = $request->class_id;

        $data['allData'] = AssignTeacher::where('year_id', $request->year_id)->get();
        return view('backend.teacher.teacher_view', $data);

    }

    public function TeacherAdd()
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['subjects'] = SchoolSubject::all();


        return view('backend.teacher.teacher_add', $data);
    }

    public function TeacherStore(Request $request)
    {
        DB::transaction(function () use ($request) {
            $checkYear = StudentYear::find($request->year_id)->name;
            $teacher = User::where('usertype', 'Teacher')->orderBy('id', 'DESC')->first();

            if ($teacher == null) {
                $firstReg = 0;
                $teacherId = $firstReg + 1;
                if ($teacherId < 10) {
                    $id_no = '000' . $teacherId;
                } elseif ($teacherId < 100) {
                    $id_no = '00' . $teacherId;
                } elseif ($teacherId < 1000) {
                    $id_no = '0' . $teacherId;
                }
            } else {
                $teacher = User::where('usertype', 'Teacher')->orderBy('id', 'DESC')->first()->id;
                $teacherId = $teacher + 1;
                if ($teacherId < 10) {
                    $id_no = '000' . $teacherId;
                } elseif ($teacherId < 100) {
                    $id_no = '00' . $teacherId;
                } elseif ($teacherId < 1000) {
                    $id_no = '0' . $teacherId;
                }

            } // end else 

            $final_id_no = $checkYear . $id_no;
            $user = new User();
            $code = rand(0000, 9999);
            $user->id_no = $final_id_no;
            $user->password = bcrypt($code);
            $user->usertype = 'Teacher';
            $user->code = $code;
            $user->name = $request->name;

            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;
            $user->email = $request->email;



            if ($request->file('image')) {
                $file = $request->file('image');
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/teacher_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();

            $assign_teacher = new AssignTeacher();
            $assign_teacher->teacher_id = $user->id;
            $assign_teacher->year_id = $request->year_id;

            $assign_teacher->class_id = json_encode($request->input('classes', []));
            $assign_teacher->subject_id = json_encode($request->input('subjects', []));

            $assign_teacher->save();




        });


        $notification = array(
            'message' => 'Teacher Registration Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('teacher.view')->with($notification);

    } // End Method 

    public function TeacherEdit($teacher_id)
    {
        $data['years'] = StudentYear::all();
        $data['classes'] = StudentClass::all();
        $data['subjects'] = SchoolSubject::all();
        $data['gender'] = User::where('id', $teacher_id)->value('gender');

        // Récupérer les matières associées à l'enseignant sélectionné
        $assignedSubjects = AssignTeacher::where('teacher_id', $teacher_id)->pluck('subject_id')->toArray();
        $assignedClasses = AssignTeacher::where('teacher_id', $teacher_id)->pluck('class_id')->toArray();

        // Passer les matières associées à la vue
        $data['assignedSubjects'] = $assignedSubjects;
        $data['assignedClasses'] = $assignedClasses;





        $data['editData'] = AssignTeacher::with(['teacher'])->where('teacher_id', $teacher_id)->first();
        // dd($data['editData']->toArray());

        return view('backend.teacher.teacher_edit', $data);

    }


    public function TeacherUpdate(Request $request, $teacher_id)
    {
        DB::transaction(function () use ($request, $teacher_id) {




            $user = User::where('id', $teacher_id)->first();
            $user->name = $request->name;
            $user->email = $request->email;

            $user->mobile = $request->mobile;
            $user->address = $request->address;
            $user->gender = $request->gender;



            if ($request->file('image')) {
                $file = $request->file('image');
                @unlink(public_path('upload/teacher_images/' . $user->image));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('upload/teacher_images'), $filename);
                $user['image'] = $filename;
            }
            $user->save();
            $assign_teacherId = AssignTeacher::where('teacher_id', $teacher_id)->first()->id;

            $assignTeacher = AssignTeacher::where('id', $assign_teacherId)->where('teacher_id', $teacher_id)->first();

            // Récupérer les valeurs actuelles de classes et de subjects de la base de données
            $currentClasses = $assignTeacher->class_id;
            $currentSubjects = $assignTeacher->subject_id;

            // Comparer les valeurs actuelles avec les nouvelles valeurs
            $newClasses = json_encode($request->input('classes', []));
            $newSubjects = json_encode($request->input('subjects', []));

            // Vérifier si les valeurs ont changé
            if ($currentClasses !== $newClasses || $currentSubjects !== $newSubjects) {
                $assignTeacher->year_id = $request->year_id;
                $assignTeacher->class_id = $newClasses;
                $assignTeacher->subject_id = $newSubjects;

                $assignTeacher->save();

            } else {
                $assignTeacher->year_id = $request->year_id;
                $assignTeacher->class_id = $currentClasses;
                $assignTeacher->subject_id = $currentSubjects;

                $assignTeacher->save();
                // Les valeurs n'ont pas été modifiées

            }


        });


        $notification = array(
            'message' => 'Teacher Registration Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('teacher.view')->with($notification);

    } // End Method 


    public function TeacherDetails($teacher_id)
    {




        $data['details'] = AssignTeacher::with(['teacher'])->where('teacher_id', $teacher_id)->first();


        $pdf = FacadesPdf::loadView('backend.teacher.teacher_details_pdf', $data);
        $pdf->SetProtection(['copy', 'print'], '', 'pass');
        return $pdf->stream('document.pdf');

    }


    public function TeacherDelete($teacher_id)
    {
        // Vérifier si l'enseignat existe dans la table 'assign_teacher'
        $assign_teacher = DB::table('assign_teacher')->where('teacher_id', $teacher_id)->first();


        if ($assign_teacher) {


            // Supprimer l'enregistrement 'assign_teacher' 
            DB::table('assign_teacher')->where('teacher_id', $teacher_id)->delete();

            // Supprimer l'utilisateur dans la table 'users'
            User::where('id', $teacher_id)->delete();

            // Retourner à la page précédente avec un message de succès
            $notification = [
                'message' => 'Teacher deleted Successfully',
                'alert-type' => 'info'
            ];
            return redirect()->back()->with($notification);
        } else {
            // Si l'étudiant n'est pas trouvé dans 'assign_students', retourner avec un message d'erreur
            $notification = [
                'message' => 'Teacher not found in assign_teacher table',
                'alert-type' => 'error'
            ];
            return redirect()->back()->with($notification);
        }
    }


}

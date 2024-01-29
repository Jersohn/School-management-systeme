<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\AssignTeacher;
use App\Models\Classroom;
use App\Models\ClassSchedule;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use niklasravnsborg\LaravelPdf\Facades\Pdf as FacadesPdf;

class ClassScheduleController extends Controller
{
    public function viewSchedule()
    {
        // Récupérer toutes les classes
        $classes = StudentClass::all();

        // Récupérer les emplois du temps de chaque classe
        $schedules = [];
        foreach ($classes as $class) {
            $schedules[$class->name] = ClassSchedule::where('class_id', $class->id)->get();
        }

        // Passer les emplois du temps à la vue
        return view('backend.setup.class_schedule.schedule_view', ['schedules' => $schedules]);
    }


    public function AddSchedule()
    {
        $data['classes'] = StudentClass::all();
        $data['teachers'] = User::where('usertype', 'Teacher')->get();
        $data['subjects'] = SchoolSubject::all();
        $data['classrooms'] = Classroom::all();
        $data['schedules'] = ClassSchedule::all();

        return view('backend.setup.class_schedule.schedule_add', $data);
    }
    public function checkClassroomAvailability(Request $request)
    {
        $classroomId = $request->input('classroom_id');
        $dayOfWeek = $request->input('day_of_week');
        $startTime = $request->input('start_time');
        $endTime = $request->input('end_time');

        // Use Eloquent queries to check for existing schedules that overlap with the provided time range
        $existingSchedules = ClassSchedule::where('classroom_id', $classroomId)
            ->where('day_of_week', $dayOfWeek)
            ->where(function ($query) use ($startTime, $endTime) {
                $query->where(function ($q) use ($startTime, $endTime) {
                    $q->where('start_time', '<=', $startTime)
                        ->where('end_time', '>=', $endTime);
                });
            })
            ->exists();

        // Return JSON response based on availability
        return response()->json(['available' => !$existingSchedules]);
    }



    public function storeSchedule(Request $request)
    {
        // Validation Rules
        $validatedData = $request->validate([
            'class_id' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'classroom_id' => 'required',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Check if the same teacher, subject, and hours exist for a different class
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id', $request->subject_id)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a le même cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
             //cas2
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas3
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time', '<=', $request->start_time)
            ->where('end_time', '>', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas4
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time', '>=', $request->start_time)
            ->where('end_time', '>', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas5
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time','>=', $request->start_time)
            ->where('end_time', '<', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }

        // Check if the same subject and hours exist for a different teacher
        $existingSubjectAndTime = ClassSchedule::where('subject_id', $request->subject_id)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('teacher_id', '!=', $request->teacher_id)
            ->exists();

        if ($existingSubjectAndTime) {
            return redirect()->back()->with([
                'message' => 'Ce cours est attribué à un autre enseignant à la même heure.',
                'alert-type' => 'error',
            ]);
        }

        // Check if the class has a different subject at the same time
        $existingClassSubjectTime = ClassSchedule::where('class_id', $request->class_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('subject_id', '!=', $request->subject_id)
            ->exists();

        if ($existingClassSubjectTime) {
            return redirect()->back()->with([
                'message' => 'Cette classe a un autre cours prévu au même moment.',
                'alert-type' => 'error',
            ]);
        }

        // Check for classroom conflict
        $classroomConflict = ClassSchedule::where('classroom_id', $request->classroom_id)
            ->where('class_id', '<=', $request->class_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                        ->orWhereBetween('end_time', [$request->start_time, $request->end_time]);
                })->orWhere(function ($q) use ($request) {
                    $q->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time);
                });
            })

            ->exists();

        if ($classroomConflict) {
            return redirect()->back()->with([
                'message' => 'Cette salle est déjà attribuée à une autre classe pendant la même période.',
                'alert-type' => 'error',
            ]);
        }

        // Check for time overlap
        $timeOverlap = ClassSchedule::where('day_of_week', $request->day_of_week)
            ->where('class_id', $request->class_id)
            ->where('classroom_id', $request->classroom_id)
            ->where(function ($query) use ($request) {
                $query->Where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->start_time)
                        ->where('end_time', '>', $request->start_time);
                })
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<', $request->end_time)
                            ->where('end_time', '>', $request->end_time);
                    });
            })
            ->exists();

        if ($timeOverlap) {
            return redirect()->back()->with([
                'message' => 'Il y a un chevauchement horaire pour cette classe le jour spécifié.',
                'alert-type' => 'error',
            ]);
        }

        // Perform subject-teacher validation
        $teacherId = $request->input('teacher_id');
        $subjectId = $request->input('subject_id');

        // Get the subjects taught by the selected teacher
        $teacherSubjects = AssignTeacher::where('teacher_id', $teacherId)
            ->pluck('subject_id')
            ->first();

        $decodedSubjects = $teacherSubjects ? json_decode($teacherSubjects, true) : [];

        // Check if the selected subject is among the subjects taught by the teacher
        $isSubjectValid = in_array($subjectId, $decodedSubjects);

        if (!$isSubjectValid) {
            $teacherSubjectsList = implode(', ', SchoolSubject::whereIn('id', $decodedSubjects)->pluck('name')->toArray());

            return redirect()->back()->with([
                'message' => "Ce professeur enseigne plutôt les matières suivantes : $teacherSubjectsList. Veuillez sélectionner l'une de ces matières.",
                'alert-type' => 'error',
            ]);
        }




        // Create a new schedule entry if validation passes
        $schedule = new ClassSchedule();
        $schedule->class_id = $request->class_id;
        $schedule->teacher_id = $request->teacher_id;
        $schedule->subject_id = $request->subject_id;
        $schedule->classroom_id = $request->classroom_id;
        $schedule->day_of_week = $request->day_of_week;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        // Add other fields to be saved

        $schedule->save();

        $notification = [
            'message' => 'Class Schedule Inserted Successfully',
            'alert-type' => 'success',
        ];

        // Redirect with a success message
        return redirect()->route('class.schedule.view')->with($notification);
    }

    public function EditSchedule($id)
    {
        $schedule = ClassSchedule::findOrFail($id);
        $data['schedule'] = $schedule;
        $data['classes'] = StudentClass::all();
        $data['teachers'] = User::where('usertype', 'Teacher')->get();
        $data['subjects'] = SchoolSubject::all();
        $data['classrooms'] = Classroom::all();

        return view('backend.setup.class_schedule.schedule_edit', $data);
    }

    public function updateSchedule(Request $request, $schedule_id)
    {
        // Validation Rules
        $validatedData = $request->validate([
            'class_id' => 'required',
            'teacher_id' => 'required',
            'subject_id' => 'required',
            'classroom_id' => 'required',
            'day_of_week' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        // Check if the same teacher, subject, and hours exist for a different class
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id', $request->subject_id)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a le même cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas2
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas3
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time', '<=', $request->start_time)
            ->where('end_time', '>', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas4
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time', '>=', $request->start_time)
            ->where('end_time', '>', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }
        //cas5
        $existingSchedule = ClassSchedule::where('teacher_id', $request->teacher_id)
            ->where('subject_id','!=', $request->subject_id)
            ->where('day_of_week',$request->day_of_week)
            ->where('start_time','>=', $request->start_time)
            ->where('end_time', '<', $request->end_time)
            ->where('class_id', '!=', $request->class_id)
            ->exists();

        if ($existingSchedule) {
            return redirect()->back()->with([
                'message' => 'Ce professeur a cours à la même heure dans une autre classe.',
                'alert-type' => 'error',
            ]);
        }

        // Check if the same subject and hours exist for a different teacher
        $existingSubjectAndTime = ClassSchedule::where('subject_id', $request->subject_id)
            ->where('start_time', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('teacher_id', '!=', $request->teacher_id)
            ->exists();

        if ($existingSubjectAndTime) {
            return redirect()->back()->with([
                'message' => 'Ce cours est attribué à un autre enseignant à la même heure.',
                'alert-type' => 'error',
            ]);
        }

        // Check if the class has a different subject at the same time
        $existingClassSubjectTime = ClassSchedule::where('class_id', $request->class_id)
            ->where('day_of_week', $request->day_of_week)
            ->where('start_time', $request->start_time)
            ->where('start_time', '<', $request->end_time)
            ->where('end_time', '>', $request->start_time)
            ->where('end_time', $request->end_time)
            ->where('subject_id', '!=', $request->subject_id)
            ->exists();

        if ($existingClassSubjectTime) {
            return redirect()->back()->with([
                'message' => 'Cette classe a un autre cours prévu au même moment.',
                'alert-type' => 'error',
            ]);
        }
        $classroomConflict = ClassSchedule::where('classroom_id', $request->classroom_id)
            ->where('class_id', '!=', $request->class_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($query) use ($request) {
                $query->Where(function ($q) use ($request) {
                    $q->where('start_time', '<=', $request->start_time)
                        ->where('end_time', '>=', $request->end_time);
                });
            })
            ->where('id', '!=', $schedule_id) // Exclude current schedule
            ->exists();

        if ($classroomConflict) {
            return redirect()->back()->with([
                'message' => 'Cette salle est déjà attribuée à une autre classe pendant la même période.',
                'alert-type' => 'error',
            ]);
        }
        // Check for time overlap
        $timeOverlap = ClassSchedule::where(function ($query) use ($request) {
            $query->where('day_of_week', $request->day_of_week)
                ->where('class_id', $request->class_id)
                ->where('classroom_id', '!=', $request->classroom_id)
                ->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                });
        })->where('id', '!=', $request->schedule_id) // Exclude the current schedule (for update case)
            ->exists();

        if ($timeOverlap) {
            return redirect()->back()->with([
                'message' => 'Il y a un chevauchement horaire pour cette classe le jour spécifié.',
                'alert-type' => 'error',
            ]);
        }
        // Perform subject-teacher validation
        $teacherId = $request->input('teacher_id');
        $subjectId = $request->input('subject_id');

        // Get the subjects taught by the selected teacher
        $teacherSubjects = AssignTeacher::where('teacher_id', $teacherId)
            ->pluck('subject_id')
            ->first();

        $decodedSubjects = $teacherSubjects ? json_decode($teacherSubjects, true) : [];

        // Check if the selected subject is among the subjects taught by the teacher
        $isSubjectValid = in_array($subjectId, $decodedSubjects);

        if (!$isSubjectValid) {
            $teacherSubjectsList = implode(', ', SchoolSubject::whereIn('id', $decodedSubjects)->pluck('name')->toArray());

            return redirect()->back()->with([
                'message' => "Ce professeur enseigne plutôt les matières suivantes : $teacherSubjectsList. Veuillez sélectionner l'une de ces matières.",
                'alert-type' => 'error',
            ]);
        }




        // Update the schedule if validation passes
        $schedule = ClassSchedule::findOrFail($schedule_id);
        $schedule->class_id = $request->class_id;
        $schedule->teacher_id = $request->teacher_id;
        $schedule->subject_id = $request->subject_id;
        $schedule->classroom_id = $request->classroom_id;
        $schedule->day_of_week = $request->day_of_week;
        $schedule->start_time = $request->start_time;
        $schedule->end_time = $request->end_time;
        // Add other fields to be updated

        $schedule->save();

        return redirect()->route('class.schedule.view')->with([
            'message' => 'Programme de classe mis à jour avec succès.',
            'alert-type' => 'success',
        ]);
    }

    public function DeleteSchedule($schedule_id)
    {
        // Trouver l'emploi du temps à supprimer
        $schedule = ClassSchedule::findOrFail($schedule_id);

        // Supprimer l'emploi du temps de la base de données
        $schedule->delete();

        $notification = array(
            'message' => 'Class Schedule Deleted Successfully',
            'alert-type' => 'info'
        );

        // Rediriger avec un message de succès
        return redirect()->route('class.schedule.view')->with($notification);
    }

    public function GeneratePDF($className)
    {
        $class = StudentClass::where('name', $className)->first(); // Récupérez les détails de la classe

        if (!$class) {
            $notification = array(
                'message' => 'This Class does not exist any more!',
                'alert-type' => 'error'
            );

            // Rediriger avec un message de succès
            return redirect()->route('class.schedule.view')->with($notification);


        }

        $classSchedules = ClassSchedule::where('class_id', $class->id)->get(); // Récupérez les détails de l'emploi du temps pour la classe sélectionnée


        $pdf = FacadesPdf::loadView('backend.setup.class_schedule.schedule_pdf', compact('classSchedules', 'class')); // Chargez la vue PDF avec les données
        return $pdf->stream('class_schedule.pdf'); // Téléchargez le fichier PDF avec le nom donné
    }





    public function viewStudentSchedule()
    {
        if (Auth::check() && Auth::user()->usertype == 'Student') {
            $studentId = Auth::id();
            return $this->viewSpecificStudentSchedule($studentId);
        } else {
            // Gérer le cas où l'utilisateur n'est pas un étudiant
        }
    }

    public function viewSpecificStudentSchedule($studentId)
    {
        // Gérer l'affichage de l'emploi du temps pour un étudiant spécifique avec l'ID $studentId
        $studentClassId = AssignStudent::where('student_id', $studentId)->value('class_id');
        $className = StudentClass::where('id', $studentClassId)->value('name');

        // Récupérer l'emploi du temps de la classe de l'étudiant
        $studentSchedule = ClassSchedule::where('class_id', $studentClassId)->get();


        // Retourner la vue avec l'emploi du temps spécifique à la classe de l'étudiant

        $pdf = FacadesPdf::loadView('backend.student.student_reg.student_schedule_view', compact('studentSchedule', 'className')); // Chargez la vue PDF avec les données
        return $pdf->stream('class_schedule.pdf');
    }
    public function viewTeacherSchedule()
    {
        if (Auth::check() && Auth::user()->usertype == 'Teacher') {
            $teacherId = Auth::id();

            return $this->viewSpecificTeacherSchedule($teacherId);
        } else {
            // Gérer le cas où l'utilisateur n'est pas un étudiant
        }
    }

    public function viewSpecificTeacherSchedule($teacherId)
    {
        $teacherName = User::where('id', $teacherId)->value('name');
        // Récupérer l'emploi du temps de la classe de l'enseignant
        $teacherSchedule = ClassSchedule::where('teacher_id', $teacherId)->get();




        // Retourner la vue avec l'emploi du temps spécifique à la classe de l'étudiant




        $pdf = FacadesPdf::loadView('backend.teacher.teacher_schedule_view', compact('teacherSchedule', 'teacherName')); // Chargez la vue PDF avec les données
        return $pdf->stream('class_schedule.pdf');
    }






}



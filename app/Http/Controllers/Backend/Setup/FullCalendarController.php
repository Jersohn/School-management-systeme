<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\AssignTeacher;
use App\Models\Calendar_schedule;
use App\Models\Classroom;
use App\Models\ClassSchedule;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FullCalendarController extends Controller
{


    public function getSubjectsByTeacher(Request $request)
    {
        // Récupérer l'identifiant de l'enseignant depuis la requête
        $teacherId = $request->input('teacherSelected');

        // Récupérer les identifiants de matières associés à l'enseignant
        $subjectIdsJson = AssignTeacher::where('teacher_id', $teacherId)->pluck('subject_id');

        // Convertir les chaînes JSON en tableaux
        $subjectIds = $subjectIdsJson->map(function ($item) {
            return json_decode($item);
        })->flatten()->unique()->toArray();

        // Récupérer les noms et les identifiants des matières correspondant aux identifiants
        $subjects = SchoolSubject::whereIn('id', $subjectIds)->get(['id', 'name']);

        // Retourner les noms et les identifiants des matières en tant que réponse JSON
        return response()->json($subjects);
    }

    public function getClass()
    {
        $data['classes'] = StudentClass::all();

        return view('backend.setup.class_schedule.classes_list', $data);


    }
    public function index(Request $request, $classId)
    {
        $data['selectedClass'] = StudentClass::where('id', $classId)->value('name');
        $data['selectedClassId'] = $classId;


        $data['classes'] = StudentClass::all();
        $data['teachers'] = User::where('usertype', 'Teacher')->get();
        $data['subjects'] = SchoolSubject::all();
        $data['classrooms'] = Classroom::all();

        // Récupérez les événements pour la classe spécifique
        $data['schedules'] = Calendar_schedule::where('class', $data['selectedClass'])->get();
        $selectedClassName = StudentClass::where('id', $classId)->value('name');

        if ($request->ajax()) {
            $schedules = Calendar_schedule::where('class', $selectedClassName)
                ->whereDate('start', '>=', $request->start)
                ->whereDate('end', '<=', $request->end)
                ->get(['id', 'class', 'teacher', 'classroom', 'subject', 'start', 'end', 'color'])
                ->map(function ($schedule) {
                    return [
                        'id' => $schedule->id,
                        'title' => $schedule->subject,
                        'start' => $schedule->start,
                        'end' => $schedule->end,
                        'teacher' => $schedule->teacher,
                        'classroom' => $schedule->classroom,
                        'color' => $schedule->color,
                    ];
                });
            return response()->json($schedules);
        }

        return view('backend.setup.class_schedule.full-calendar', $data);
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
        // Récupérer l'identifiant de la classe de l'étudiant
        $studentClassId = AssignStudent::where('student_id', $studentId)->value('class_id');
        // Récupérer le nom de la classe de l'étudiant
        $className = StudentClass::where('id', $studentClassId)->value('name');

        if (request()->ajax()) {
            $studentSchedule = Calendar_schedule::where('class', $className)
                ->get(['id', 'class', 'teacher', 'classroom', 'subject', 'start', 'end', 'color']);

            return response()->json($studentSchedule);
        }

        return view('backend.student.student_reg.student_schedule_view', [

            'className' => $className,
        ]);
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


        if (request()->ajax()) {
            $teacherSchedule = Calendar_schedule::where('teacher', $teacherName)
                ->get(['id', 'class', 'teacher', 'classroom', 'subject', 'start', 'end', 'color']);

            return response()->json($teacherSchedule);
        }

        return view('backend.teacher.teacher_schedule_view', [

            'teacherName' => $teacherName,
        ]);
    }







    public function action(Request $request)
    {
        if ($request->ajax()) {
            $event = null;  // Initialisez l'objet $event à null

            try {
                // Ajoutez des vérifications de conflits ici
                switch ($request->type) {
                    case 'add':
                        $teacherName = User::where('id', $request->teacher)->value('name');
                        // Vérifier la redondance des données
                        $existingEvent = Calendar_schedule::where([
                            'class' => $request->class,
                            'teacher' => $teacherName,
                            'subject' => $request->subject,
                            'classroom' => $request->classroom,
                            'start' => $request->start,
                            'end' => $request->end,
                        ])->first();

                        if ($existingEvent) {
                            return response()->json(['error' => 'Conflit de données. Cet événement existe déjà.'], 400);
                        }

                        // Vérifier si le professeur est déjà assigné à une autre classe pendant la même période
                        $teacherConflict = Calendar_schedule::where([
                            'teacher' => $teacherName,
                            'start' => $request->start,
                            'end' => $request->end,
                        ])->first();

                        if ($teacherConflict) {
                            return response()->json(['error' => 'Conflit de professeur. Le professeur est déjà assigné à une autre classe pendant cette période.'], 400);
                        }

                        // Vérifier si la salle est déjà occupée pendant la même période
                        $classroomConflict = Calendar_schedule::where([
                            'classroom' => $request->classroom,
                            'start' => $request->start,
                            'end' => $request->end,
                        ])->first();

                        if ($classroomConflict) {
                            return response()->json(['error' => 'Conflit de salle. La salle est déjà occupée pendant cette période.'], 400);
                        }
                        // Vérifier si la classe a une matière différente pendant la même période
                        $classSubjectConflict = Calendar_schedule::where([
                            ['id', '!=', $request->id],
                            ['class', '=', $request->class],
                            ['start', '=', $request->start],
                            ['end', '=', $request->end],
                        ])->first();

                        if ($classSubjectConflict) {
                            return response()->json(['error' => 'Conflit de classe. La classe a un cours différent pendant cette période.'], 400);
                        }
                        // Vérifier les chevauchements horaires pour le même enseignant
                        $teacherOverlap = Calendar_schedule::where('teacher', $teacherName)
                            ->where(function ($query) use ($request) {
                                $query->where('start', '<', $request->end)
                                    ->where('end', '>', $request->start);
                            })
                            ->first();

                        if ($teacherOverlap) {
                            return response()->json(['error' => 'Conflit horaire. Le professeur a déjà un événement planifié pendant cette période.'], 400);
                        }
                        // Vérifier les chevauchements horaires pour la même classe avec un autre enseignant dans une autre salle
                        $classOverlap = Calendar_schedule::where('class', $request->class)
                            ->where(function ($query) use ($request, $teacherName) {
                                $query->where('teacher', '!=', $teacherName)
                                    ->where('classroom', '!=', $request->classroom)
                                    ->where(function ($query) use ($request) {
                                        $query->where('start', '<', $request->end)
                                            ->where('end', '>', $request->start);
                                    });
                            })
                            ->first();

                        if ($classOverlap) {
                            return response()->json(['error' => 'Conflit horaire. La classe a un cours avec un autre enseignant dans une autre salle pendant cette période.'], 400);
                        }




                        // Ajouter d'autres vérifications de conflits ici...

                        $event = Calendar_schedule::create([
                            'teacher' => $teacherName,
                            'class' => $request->class,
                            'classroom' => $request->classroom,
                            'subject' => $request->subject,
                            'start' => $request->start,
                            'end' => $request->end,
                            'color' => $request->color,
                        ]);
                        break;

                    case 'update':
                        // Vérifications de conflits pour la mise à jour d'un événement
                        // Récupérer l'événement existant
                        $existingEvent = Calendar_schedule::findOrFail($request->id);


                        // Vérifier la redondance des données
                        $existingEvents = Calendar_schedule::where([
                            ['id', '!=', $request->id],
                            ['class', '=', $request->class],
                            ['teacher', '=', $request->teacher],
                            ['subject', '=', $request->subject],
                            ['classroom', '=', $request->classroom],
                            ['start', '=', $request->start],
                            ['end', '=', $request->end],
                        ])->first();

                        if ($existingEvents) {
                            return response()->json(['error' => 'Conflit de données. Cet événement existe déjà.'], 400);
                        }

                        // Vérifier si le professeur est déjà assigné à une autre classe pendant la même période
                        $teacherConflict = Calendar_schedule::where([
                            ['id', '!=', $request->id],
                            ['teacher', '=', $request->teacher],
                            ['start', '=', $request->start],
                            ['end', '=', $request->end],
                        ])->first();

                        if ($teacherConflict) {
                            return response()->json(['error' => 'Conflit de professeur. Le professeur est déjà assigné à une autre classe pendant cette période.'], 400);
                        }

                        // Vérifier si la salle est déjà occupée pendant la même période
                        $classroomConflict = Calendar_schedule::where([
                            ['id', '!=', $request->id],
                            ['classroom', '=', $request->classroom],
                            ['start', '=', $request->start],
                            ['end', '=', $request->end],
                        ])->first();

                        if ($classroomConflict) {
                            return response()->json(['error' => 'Conflit de salle. La salle est déjà occupée pendant cette période.'], 400);
                        }
                        // Vérifier si la classe a une matière différente pendant la même période
                        $classSubjectConflict = Calendar_schedule::where([
                            ['id', '!=', $request->id],
                            ['class', '=', $request->class],
                            ['start', '=', $request->start],
                            ['end', '=', $request->end],
                        ])->first();

                        if ($classSubjectConflict) {
                            return response()->json(['error' => 'Conflit de classe. La classe a un cours différent pendant cette période.'], 400);
                        }
                        // Vérifier les chevauchements horaires pour le même enseignant
                        $teacherOverlap = Calendar_schedule::where('teacher', $request->teacher)
                            ->where(function ($query) use ($request) {
                                $query->where('start', '<', $request->end)
                                    ->where('end', '>', $request->start);
                            })
                            ->first();

                        if ($teacherOverlap) {
                            return response()->json(['error' => 'Conflit horaire. Le professeur a déjà un événement planifié pendant cette période.'], 400);
                        }
                        // Vérifier les chevauchements horaires pour la même classe avec un autre enseignant dans une autre salle
                        $classOverlap = Calendar_schedule::where('class', $request->class)
                            ->where(function ($query) use ($request) {
                                $query->where('teacher', '!=', $request->teacher)
                                    ->where('classroom', '!=', $request->classroom)
                                    ->where(function ($query) use ($request) {
                                        $query->where('start', '<', $request->end)
                                            ->where('end', '>', $request->start);
                                    });
                            })
                            ->first();

                        if ($classOverlap) {
                            return response()->json(['error' => 'Conflit horaire. La classe a un cours avec un autre enseignant dans une autre salle pendant cette période.'], 400);
                        }




                        // Mise à jour de l'événement
                        $existingEvent->update([
                            'teacher' => $request->teacher,
                            'class' => $request->class,
                            'subject' => $request->subject,
                            'classroom' => $request->classroom,
                            'start' => $request->start,
                            'end' => $request->end,
                            'color' => $request->color,
                        ]);
                        $event = $existingEvent;
                        break;

                    case 'delete':
                        $event = Calendar_schedule::findOrFail($request->id);
                        $event->delete();
                        break;

                    default:
                        // Gérez d'autres types d'actions si nécessaire
                        break;
                }
            } catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 500);
            }

            return response()->json($event);
        }
    }

}

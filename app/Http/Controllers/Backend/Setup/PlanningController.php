<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;


use App\Models\Planning;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class PlanningController extends Controller
{


    public function showPlanning()
    {
        // Récupérer toutes les classes
        $classes = StudentClass::all();

        // Récupérer toutes les matières
        $subjects = SchoolSubject::all();

        // Récupérer tous les plannings
        $plannings = Planning::all();

        return view('backend.setup.class_schedule.planning', [
            'classes' => $classes,
            'subjects' => $subjects,
            'plannings' => $plannings,
        ]);
    }
    public function createPlanning()
    {
        $data['subjects'] = SchoolSubject::all();
        $data['classes'] = StudentClass::all();

        return view('backend.setup.class_schedule.planning_add', $data);
    }
    public function storePlanning(Request $request)
    {
        // Valider les données du formulaire
        $request->validate([
            'student_class' => 'required|exists:student_classes,id',
        ]);

        // Récupérer l'ID de la classe
        $classId = $request->student_class;

        // Parcourir les données pour extraire les heures pour chaque matière
        foreach ($request->except('_token', 'student_class') as $key => $value) {
            // Extraire l'ID de la matière à partir du nom du champ
            $subjectId = intval(str_replace('hours_', '', $key));

            // Enregistrer les heures dans la base de données
            $planning = new Planning();
            $planning->class_id = $classId;
            $planning->subject_id = $subjectId;
            $planning->hours = $value;
            $planning->save();
        }

        $notification = array(
            'message' => 'Volume horaire ajouté avec success',
            'alert-type' => 'success'
        );

        // Rediriger l'utilisateur ou afficher un message de succès
        return redirect()->route('planning.show')->with($notification);
    }

    public function editPlanning($class_id)
    {
        $className = StudentClass::where('id', $class_id)->value('name');
        $data['classe'] = $className;
        $data['classId'] = $class_id;
        $planning = Planning::where('class_id', $class_id)->get();
        $data['planning'] = $planning;

        $data['subjects'] = SchoolSubject::all();

        return view('backend.setup.class_schedule.planning_edit', $data);
    }

    public function updatePlanning(Request $request, $class_id)
    {
        $request->validate([
            'class' => 'required|exists:student_classes,id',
            // Vous pouvez ajouter des validations supplémentaires ici si nécessaire
        ]);

        // Récupérez la classe


        // Boucle sur les données de demande pour mettre à jour les plannings
        foreach ($request->except('_token', 'class') as $key => $value) {
            // Extraire l'ID de la matière à partir du nom du champ
            $subjectId = intval(str_replace('hours_', '', $key));

            // Vérifiez si un planning existe déjà pour cette combinaison de classe et de matière
            $planning = Planning::where('class_id', $class_id)
                ->where('subject_id', $subjectId)
                ->first();

            // Si un planning existe, mettez à jour le volume horaire, sinon créez un nouveau planning
            if ($planning) {
                $planning->hours = $value;
                $planning->save();
            } else {
                $planning = new Planning();
                $planning->class_id = $class_id;
                $planning->subject_id = $subjectId;
                $planning->hours = $value;
                $planning->save();
            }
        }

        // Redirigez l'utilisateur avec un message de succès
        return redirect()->route('planning.show')->with([
            'message' => 'Volume horaire modifié avec succès',
            'alert-type' => 'success'
        ]);
    }




}

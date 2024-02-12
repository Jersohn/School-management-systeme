<?php

namespace App\Http\Controllers;

use App\Models\Assign_module;
use App\Models\Classroom;
use App\Models\Planning;
use App\Models\SchoolSubject;
use App\Models\StudentClass;
use App\Models\User;
use Illuminate\Http\Request;

class AssignModuleController extends Controller
{
    public function showModule()
    {
        $assignModules = Assign_module::all();
        return view('backend.setup.module.module_show', compact('assignModules'));
    }
    public function createModule()
    {
        $classes = StudentClass::all();
        $subjects = SchoolSubject::all();
        $classrooms = Classroom::all();
        $teachers = User::where('usertype', 'Teacher')->get();

        return view('backend.setup.module.module_add', [
            'classes' => $classes,
            'subjects' => $subjects,
            'classrooms' => $classrooms,
            'teachers' => $teachers,
        ]);
    }
    public function storeModule(Request $request)
    {
        // Validez les données du formulaire
        $request->validate([
            'subject_id' => 'required',
            'class_id' => 'required',
            'teacher_id' => 'required',
            'classroom_id' => 'required',

        ]);

        // Associez les identifiants de matière à une couleur spécifique
        $colors = [
            1 => '#FF5733',
            2 => '#33FF57',
            // Ajoutez d'autres associations ici
        ];

        // Créez un nouvel objet Module avec les données du formulaire
        $module = new Assign_module();
        $module->subject_id = $request->subject_id;
        $module->class_id = $request->class_id;
        $module->teacher_id = $request->teacher_id;
        $module->classroom_id = $request->classroom_id;


        if (isset($colors[$request->subject_id])) {
            $module->color = $colors[$request->subject_id];
        } else {
            // Générez une couleur aléatoire si l'identifiant de la matière n'est pas trouvé dans le tableau
            $module->color = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $colors[$request->subject_id] = $module->color;
        }

        // Utilisez la relation planning pour obtenir la somme des heures pour cette classe et cette matière
        $plannings = Planning::where('class_id', $request->class_id)
            ->where('subject_id', $request->subject_id)
            ->get();
        $hoursPerYear = $plannings->sum('hours');

        // Assignez la valeur de hours_per_year au module
        $module->hour_per_year = $hoursPerYear;

        // Enregistrez le module dans la base de données
        $module->save();

        // Redirigez l'utilisateur vers une autre page ou affichez un message de succès
        return redirect()->route('module.show')->with([
            'message' => 'Module ajouté avec succès',
            'alert-type' => 'success'
        ]);
    }


}

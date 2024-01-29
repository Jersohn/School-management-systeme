<?php

namespace App\Http\Controllers\Backend\Setup;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    public function ViewClassroom()
    {
        $data['allData'] = Classroom::all();
        return view('backend.setup.classroom.view_classroom', $data);

    }

    public function ClassroomAdd()
    {
        return view('backend.setup.classroom.add_classroom');
    }

    public function ClassroomStore(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|unique:classroom,name',

        ]);

        $data = new Classroom();
        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Classroom Inserted Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.classroom.view')->with($notification);

    }


    public function ClassroomEdit($id)
    {
        $editData = Classroom::find($id);
        return view('backend.setup.classroom.edit_classroom', compact('editData'));
    }



    public function ClassroomUpdate(Request $request, $id)
    {

        $data = Classroom::find($id);

        $validatedData = $request->validate([
            'name' => 'required|unique:school_subjects,name,' . $data->id

        ]);


        $data->name = $request->name;
        $data->save();

        $notification = array(
            'message' => 'Classroom Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->route('school.classroom.view')->with($notification);
    }


    public function ClassroomDelete($id)
    {
        $subject = Classroom::find($id);
        $subject->delete();

        $notification = array(
            'message' => 'Classroom Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('school.classroom.view')->with($notification);

    }

}

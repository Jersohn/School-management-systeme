<?php

namespace App\Http\Controllers\Backend\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AssignStudent;
use App\Models\Course;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CoursesController extends Controller
{


    public function ShowCourses()
    {
        $teacherId = Auth::id();
        $teacherName = Auth::user()->name;


        $courses = Course::where('teacher_id', $teacherId)->get();


        return view('backend.teacher.show_courses', compact('courses', 'teacherName'));


    }

    public function uploadCourses()
    {
        $Classes = StudentClass::All();
        return view('backend.teacher.upload_courses', compact('Classes'));
    }


    public function storeCourses(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'course_file' => 'required|mimes:pdf,doc,docx|max:2048',
            'class_id' => 'required',
            // Modify the allowed file types and size as needed
        ]);

        // Handle file upload
        if ($request->hasFile('course_file')) {
            $file = $request->file('course_file');
            $fileName = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/course_files'), $fileName);
        }

        // Save course details to the database
        $course = new Course();
        $course->name = $request->input('name');
        $course->class_id = $request->input('class_id');

        $course->file_path = 'upload/course_files/' . $fileName ?? null; // Save the file path if file was uploaded
        $course->teacher_id = auth()->id(); // Set teacher_id from currently authenticated user
        $course->save();

        // Redirect with success message
        $notification = array(
            'message' => 'Course uploaded successfully.',
            'alert-type' => 'success'
        );

        // Redirect back or to any other page after successful upload
        return redirect()->route('show.courses')->with($notification);

    }

    public function displayCourse($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('backend.teacher.display_course')->with('course', $course);
    }

    public function EditCourse($course_id)
    {
        $oldCourse = Course::findOrFail($course_id);

        return view('backend.teacher.edit_course')->with('oldCourse', $oldCourse);

    }
    public function UpdateCourse(Request $request, $course_id)
    {

        $updatedCourse = Course::find($course_id);

        if (!$updatedCourse) {
            abort(404); // Course not found
        }

        // Update course name
        $updatedCourse->name = $request->input('name');

        // Handle file upload if provided
        if ($request->hasFile('course_file')) {
            $file = $request->file('course_file');
            @unlink(public_path('upload/course_files/' . $updatedCourse->file_path));
            $fileName = date('YmdHi') . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload/course_files'), $fileName);

            // Update file path in the database

            $updatedCourse->file_path = 'upload/course_files/' . $fileName ?? null;
        }


        $updatedCourse->save();


        $notification = [
            'message' => 'Course Updated Successfully',
            'alert-type' => 'info'
        ];

        return redirect()->route('show.courses')->with($notification);
    }


    public function DeleteCourse($course_id)
    {
        $course = Course::findOrFail($course_id);
        $course->delete();

        $notification = array(
            'message' => 'Subject Deleted Successfully',
            'alert-type' => 'info'
        );

        return redirect()->route('show.courses')->with($notification);

    }






    public function ShowStudentCourse($student_id)
    {
        $studentClassId = AssignStudent::where('student_id', $student_id)->value('class_id');

        $studentCourse = Course::where('class_id', $studentClassId)->get();

        return view('backend.student.student_reg.display_course', compact('studentCourse'));
    }


    public function DisplayStudentCourse($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('backend.student.student_reg.displayStudent_course')->with('course', $course);
    }
    public function ShowAdminCourse()
    {

        $studentCourse = Course::all();

        return view('backend.setup.courses.show_all_courses', compact('studentCourse'));
    }


    public function DisplayAdminCourse($course_id)
    {
        $course = Course::findOrFail($course_id);
        return view('backend.setup.courses.displayAdmin_course')->with('course', $course);
    }






}

<?php


use App\Http\Controllers\Backend\Setup\ClassroomController;
use App\Http\Controllers\Backend\Teacher\TeacherSalaryController;
use App\Models\AssignStudent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\Setup\StudentClassController;
use App\Http\Controllers\Backend\Setup\StudentYearController;
use App\Http\Controllers\Backend\Setup\StudentGroupController;
use App\Http\Controllers\Backend\Setup\StudentShiftController;
use App\Http\Controllers\Backend\Setup\FeeCategoryController;
use App\Http\Controllers\Backend\Setup\FeeAmountControllere;
use App\Http\Controllers\Backend\Setup\ExamTypeController;
use App\Http\Controllers\Backend\Setup\SchoolSubjectController;
use App\Http\Controllers\Backend\Setup\AssignSubjectController;
use App\Http\Controllers\Backend\Setup\DesignationController;

use App\Http\Controllers\Backend\Student\StudentRegController;
use App\Http\Controllers\Backend\Student\StudentRollController;
use App\Http\Controllers\Backend\Student\RegistrationFeeController;
use App\Http\Controllers\Backend\Student\MonthlyFeeController;
use App\Http\Controllers\Backend\Student\ExamFeeController;

use App\Http\Controllers\Backend\Teacher\teacherRegController;

use App\Http\Controllers\Backend\Employee\EmployeeRegController;
use App\Http\Controllers\Backend\Employee\EmployeeSalaryController;
use App\Http\Controllers\Backend\Employee\EmployeeLeaveController;
use App\Http\Controllers\Backend\Employee\EmployeeAttendanceController;
use App\Http\Controllers\Backend\Employee\MonthlySalaryController;

use App\Http\Controllers\Backend\Marks\MarksController;
use App\Http\Controllers\Backend\Marks\GradeController;

use App\Http\Controllers\Backend\DefaultController;

use App\Http\Controllers\Backend\Account\StudentFeeController;
use App\Http\Controllers\Backend\Account\AccountSalaryController;
use App\Http\Controllers\Backend\Account\OtherCostController;

use App\Http\Controllers\Backend\Report\ProfiteController;
use App\Http\Controllers\Backend\Report\MarkSheetController;
use App\Http\Controllers\Backend\Report\AttenReportController;
use App\Http\Controllers\Backend\Report\ResultReportController;
use App\Http\Controllers\Backend\Setup\ClassScheduleController;
use App\Http\Controllers\Backend\Teacher\CoursesController;
use App\Models\Classroom;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'prevent-back-history'], function () {




    Route::get('/', function () {
        return view('auth.login');
    });

    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DefaultController::class, 'index'])->name('dashboard');
// Route::get('login', [AuthController::class,'authenticate'])->name('login');



    Route::get('/admin/logout', [AdminController::class, 'Logout'])->name('admin.logout');


    Route::group(['middleware' => 'auth'], function () {


        // User Management All Routes 

        Route::prefix('users')->group(function () {

            Route::get('/view', [UserController::class, 'UserView'])->name('user.view');

            Route::get('/add', [UserController::class, 'UserAdd'])->name('users.add');

            Route::post('/store', [UserController::class, 'UserStore'])->name('users.store');

            Route::get('/edit/{id}', [UserController::class, 'UserEdit'])->name('users.edit');
            Route::post('/update/{id}', [UserController::class, 'UserUpdate'])->name('users.update');

            Route::get('/delete/{id}', [UserController::class, 'UserDelete'])->name('users.delete');

        });

        /// User Profile and Change Password 
        Route::prefix('profile')->group(function () {

            Route::get('/view', [ProfileController::class, 'ProfileView'])->name('profile.view');

            Route::get('/edit', [ProfileController::class, 'ProfileEdit'])->name('profile.edit');

            Route::post('/store', [ProfileController::class, 'ProfileStore'])->name('profile.store');

            Route::get('/password/view', [ProfileController::class, 'PasswordView'])->name('password.view');

            Route::post('/password/update', [ProfileController::class, 'PasswordUpdate'])->name('password.update');

        });



        /// User Profile and Change Password 
        Route::prefix('setups')->group(function () {

            // Student Class Routes 
            Route::get('student/class/view', [StudentClassController::class, 'ViewStudent'])->name('student.class.view');

            Route::get('student/class/add', [StudentClassController::class, 'StudentClassAdd'])->name('student.class.add');

            Route::post('student/class/store', [StudentClassController::class, 'StudentClassStore'])->name('store.student.class');

            Route::get('student/class/edit/{id}', [StudentClassController::class, 'StudentClassEdit'])->name('student.class.edit');

            Route::post('student/class/update/{id}', [StudentClassController::class, 'StudentClassUpdate'])->name('update.student.class');

            Route::get('student/class/delete/{id}', [StudentClassController::class, 'StudentClassDelete'])->name('student.class.delete');

            // Student Year Routes 

            Route::get('student/year/view', [StudentYearController::class, 'ViewYear'])->name('student.year.view');

            Route::get('student/year/add', [StudentYearController::class, 'StudentYearAdd'])->name('student.year.add');

            Route::post('student/year/store', [StudentYearController::class, 'StudentYearStore'])->name('store.student.year');

            Route::get('student/year/edit/{id}', [StudentYearController::class, 'StudentYearEdit'])->name('student.year.edit');

            Route::post('student/year/update/{id}', [StudentYearController::class, 'StudentYearUpdate'])->name('update.student.year');

            Route::get('student/year/delete/{id}', [StudentYearController::class, 'StudentYearDelete'])->name('student.year.delete');


            // Student Group Routes 

            Route::get('student/group/view', [StudentGroupController::class, 'ViewGroup'])->name('student.group.view');

            Route::get('student/group/add', [StudentGroupController::class, 'StudentGroupAdd'])->name('student.group.add');

            Route::post('student/group/store', [StudentGroupController::class, 'StudentGroupStore'])->name('store.student.group');

            Route::get('student/group/edit/{id}', [StudentGroupController::class, 'StudentGroupEdit'])->name('student.group.edit');

            Route::post('student/group/update/{id}', [StudentGroupController::class, 'StudentGroupUpdate'])->name('update.student.group');

            Route::get('student/group/delete/{id}', [StudentGroupController::class, 'StudentGroupDelete'])->name('student.group.delete');





            // Fee Category Routes 

            Route::get('fee/category/view', [FeeCategoryController::class, 'ViewFeeCat'])->name('fee.category.view');

            Route::get('fee/category/add', [FeeCategoryController::class, 'FeeCatAdd'])->name('fee.category.add');

            Route::post('fee/category/store', [FeeCategoryController::class, 'FeeCatStore'])->name('store.fee.category');

            Route::get('fee/category/edit/{id}', [FeeCategoryController::class, 'FeeCatEdit'])->name('fee.category.edit');

            Route::post('fee/category/update/{id}', [FeeCategoryController::class, 'FeeCategoryUpdate'])->name('update.fee.category');

            Route::get('fee/category/delete/{id}', [FeeCategoryController::class, 'FeeCategoryDelete'])->name('fee.category.delete');

            // Fee Category Amount Routes 

            Route::get('fee/amount/view', [FeeAmountControllere::class, 'ViewFeeAmount'])->name('fee.amount.view');

            Route::get('fee/amount/add', [FeeAmountControllere::class, 'AddFeeAmount'])->name('fee.amount.add');

            Route::post('fee/amount/store', [FeeAmountControllere::class, 'StoreFeeAmount'])->name('store.fee.amount');

            Route::get('fee/amount/edit/{fee_category_id}', [FeeAmountControllere::class, 'EditFeeAmount'])->name('fee.amount.edit');

            Route::post('fee/amount/update/{fee_category_id}', [FeeAmountControllere::class, 'UpdateFeeAmount'])->name('update.fee.amount');

            Route::get('fee/amount/details/{fee_category_id}', [FeeAmountControllere::class, 'DetailsFeeAmount'])->name('fee.amount.details');





            // School Subject All Routes 

            Route::get('school/subject/view', [SchoolSubjectController::class, 'ViewSubject'])->name('school.subject.view');

            Route::get('school/subject/add', [SchoolSubjectController::class, 'SubjectAdd'])->name('school.subject.add');

            Route::post('school/subject/store', [SchoolSubjectController::class, 'SubjectStore'])->name('store.school.subject');

            Route::get('school/subject/edit/{id}', [SchoolSubjectController::class, 'SubjectEdit'])->name('school.subject.edit');

            Route::post('school/subject/update/{id}', [SchoolSubjectController::class, 'SubjectUpdate'])->name('update.school.subject');

            Route::get('school/subject/delete/{id}', [SchoolSubjectController::class, 'SubjectDelete'])->name('school.subject.delete');






            //Class Schedule All Routes
            Route::get('class/schedule/view', [ClassScheduleController::class, 'ViewSchedule'])->name('class.schedule.view');



            Route::get('class/schedule/add', [ClassScheduleController::class, 'AddSchedule'])->name('class.schedule.add');


            Route::post('class/schedule/store', [ClassScheduleController::class, 'StoreSchedule'])->name('class.schedule.store');
            Route::get('class/schedule/edit/{schedule_id}', [ClassScheduleController::class, 'EditSchedule'])->name('class.schedule.edit');
            Route::post('class/schedule/update/{schedule_id}', [ClassScheduleController::class, 'UpdateSchedule'])->name('class.schedule.update');
            Route::get('class/schedule/delete/{schedule_id}', [ClassScheduleController::class, 'DeleteSchedule'])->name('class.schedule.delete');
            Route::get('class/schedule/pdf/{class_id}', [ClassScheduleController::class, 'GeneratePDF'])->name('class.schedule.pdf');
            Route::get('courses/view/all', [CoursesController::class, 'ShowAdminCourse'])->name('show.AdminCourses');
            Route::get('display/course/{course_id}', [CoursesController::class, 'DisplayAdminCourse'])->name('display.AdminCourse');

            //Classroom routes

            Route::get('school/classroom/view', [ClassroomController::class, 'ViewClassroom'])->name('school.classroom.view');

            Route::get('school/classroom/add', [ClassroomController::class, 'ClassroomAdd'])->name('school.classroom.add');

            Route::post('school/classroom/store', [ClassroomController::class, 'ClassroomStore'])->name('store.school.classroom');

            Route::get('school/classroom/edit/{id}', [ClassroomController::class, 'ClassroomEdit'])->name('school.classroom.edit');

            Route::post('school/classroom/update/{id}', [ClassroomController::class, 'ClassroomUpdate'])->name('update.school.classroom');

            Route::get('school/classroom/delete/{id}', [ClassroomController::class, 'ClassroomDelete'])->name('school.classroom.delete');









        });


        /// Student Registration Routes  
        Route::prefix('students')->group(function () {

            Route::get('/reg/view', [StudentRegController::class, 'StudentRegView'])->name('student.registration.view');
            Route::get('/list/view', [StudentRegController::class, 'StudentList'])->name('student.print.list');

            Route::get('/classmat/view/{student_id}', [DefaultController::class, 'ShowStdentInClass'])->name('show.class.student');
            Route::get('/Teachers/view/{student_id}', [DefaultController::class, 'ShowTeacherInClass'])->name('show.class.teachers');
            Route::get('/Subjects/view/{student_id}', [DefaultController::class, 'ShowClassSubject'])->name('show.class.subjects');

            Route::get('/reg/Add', [StudentRegController::class, 'StudentRegAdd'])->name('student.registration.add');

            Route::post('/reg/store', [StudentRegController::class, 'StudentRegStore'])->name('store.student.registration');

            Route::get('/year/class/wise', [StudentRegController::class, 'StudentClassYearWise'])->name('student.year.class.wise');

            Route::get('/reg/edit/{student_id}', [StudentRegController::class, 'StudentRegEdit'])->name('student.registration.edit');

            Route::post('/reg/update/{student_id}', [StudentRegController::class, 'StudentRegUpdate'])->name('update.student.registration');

            Route::get('/reg/promotion/{student_id}', [StudentRegController::class, 'StudentRegPromotion'])->name('student.registration.promotion');

            Route::post('/reg/update/promotion/{student_id}', [StudentRegController::class, 'StudentUpdatePromotion'])->name('promotion.student.registration');

            Route::get('/reg/details/{student_id}', [StudentRegController::class, 'StudentRegDetails'])->name('student.registration.details');
            Route::get('/reg/delete/{student_id}', [StudentRegController::class, 'StudentRegDelete'])->name('student.registration.delete');


            Route::get('/students/schedule/view', [ClassScheduleController::class, 'viewStudentSchedule'])->name('student.schedule.view');
            Route::get('/students/schedule/view/{student_id}', [ClassScheduleController::class, 'viewSpecificStudentSchedule'])->name('specific.student.schedule.view');

            Route::get('/students/course/view/{student_id}', [CoursesController::class, 'ShowStudentCourse'])->name('show.studentCourses');
            Route::get('/display/course/{course_id}', [CoursesController::class, 'DisplayStudentCourse'])->name('display.studentCourse');
            Route::get('result/get/{student_id}/{class_id}', [ResultReportController::class, 'StudentResultGet'])->name('report.single.result.get');
            Route::get('result/view', [ResultReportController::class, 'StudentResultView'])->name('single.student.result.view');




            // Student Roll Generate Routes 


            // Registration Fee Routes 
            Route::get('/reg/fee/view', [RegistrationFeeController::class, 'RegFeeView'])->name('registration.fee.view');

            Route::get('/reg/fee/classwisedata', [RegistrationFeeController::class, 'RegFeeClassData'])->name('student.registration.fee.classwise.get');

            Route::get('/reg/paiement/process', [RegistrationFeeController::class, 'PayFees'])->name('payment.process');
            Route::post('/reg/paiement/store/{class_id}/{student_id}', [RegistrationFeeController::class, 'PaymentProcessStore'])->name('payment.store');
            Route::get('/reg/fee/payslip', [RegistrationFeeController::class, 'RegFeePayslip'])->name('student.registration.fee.payslip');
            Route::get('student/idcard/view', [ResultReportController::class, 'IdcardView'])->name('student.idcard.view');

            Route::get('student/idcard/get', [ResultReportController::class, 'IdcardGet'])->name('report.student.idcard.get');





        });

        /// Teacher Registration Routes

        Route::prefix('teachers')->group(function () {

            Route::get('/view', [teacherRegController::class, 'TeacherView'])->name('teacher.view');
            Route::get('Students/view/{teacher_id}', [DefaultController::class, 'ShowTeacherStudent'])->name('students.show');
            Route::get('Classes/view/{teacher_id}', [DefaultController::class, 'ShowTeacherClasses'])->name('classes.show');
            Route::get('Subjects/view/{teacher_id}', [DefaultController::class, 'ShowTeacherSubjects'])->name('subjects.show');
            Route::get('Subjects/display/{teacher_id}', [DefaultController::class, 'DisplayTeacherSubjects'])->name('subjects.display');
            Route::get('/year/wise', [teacherRegController::class, 'TeacherYearWise'])->name('teacher.year.wise');


            Route::get('/Add', [teacherRegController::class, 'TeacherAdd'])->name('teacher.add');

            Route::post('/store', [teacherRegController::class, 'TeacherStore'])->name('store.teacher');


            Route::get('/edit/{teacher_id}', [teacherRegController::class, 'TeacherEdit'])->name('teacher.edit');

            Route::post('/update/{teacher_id}', [teacherRegController::class, 'TeacherUpdate'])->name('update.teacher');


            Route::get('/details/{teacher_id}', [teacherRegController::class, 'TeacherDetails'])->name('teacher.details');
            Route::get('/delete/{teacher_id}', [TeacherRegController::class, 'TeacherDelete'])->name('teacher.delete');

            // Teacher Salary All Routes 

            Route::get('salary/view', [TeacherSalaryController::class, 'SalaryView'])->name('teacher.salary.view');

            Route::get('/salary/increment/{id}', [TeacherSalaryController::class, 'SalaryIncrement'])->name('teacher.salary.increment');

            Route::post('/salary/store/{id}', [TeacherSalaryController::class, 'SalaryStore'])->name('update.increment.store');

            Route::get('/salary/details/{id}', [TeacherSalaryController::class, 'SalaryDetails'])->name('teacher.salary.details');
            //Teacher Schedule Routes

            Route::get('/teachers/schedule/view', [ClassScheduleController::class, 'viewTeacherSchedule'])->name('teacher.schedule.view');
            Route::get('/teachers/schedule/view/{teacher_id}', [ClassScheduleController::class, 'viewSpecificTeacherSchedule'])->name('specific.teacher.schedule.view');

            // Teacher courses Routes
            Route::get('/show/courses', [CoursesController::class, 'ShowCourses'])->name('show.courses');
            Route::get('/upload/courses', [CoursesController::class, 'uploadCourses'])->name('course.add');
            Route::post('/store/courses', [CoursesController::class, 'storeCourses'])->name('store.courses');
            Route::get('/display/course/{course_id}', [CoursesController::class, 'DisplayCourse'])->name('display.course');

            Route::get('/course/edit/{course_id}', [CoursesController::class, 'EditCourse'])->name('edit.course');
            Route::post('/course/update/{course_id}', [CoursesController::class, 'UpdateCourse'])->name('update.course');

            Route::get('/course/delete/{course_id}', [CoursesController::class, 'DeleteCourse'])->name('delete.course');

        });

        /// Marks Management Routes  
Route::prefix('marks')->group(function(){

Route::get('marks/entry/add', [MarksController::class, 'MarksAdd'])->name('marks.entry.add');

Route::post('marks/entry/store', [MarksController::class, 'MarksStore'])->name('marks.entry.store'); 

Route::get('marks/entry/edit', [MarksController::class, 'MarksEdit'])->name('marks.entry.edit'); 

Route::get('marks/getstudents/edit', [MarksController::class, 'MarksEditGetStudents'])->name('student.edit.getstudents');

Route::post('marks/entry/update', [MarksController::class, 'MarksUpdate'])->name('marks.entry.update'); 
// MarkSheet Generate Routes 
Route::get('marksheet/generate/view', [MarkSheetController::class, 'MarkSheetView'])->name('marksheet.generate.view');

Route::get('marksheet/generate/get', [MarkSheetController::class, 'MarkSheetGet'])->name('report.marksheet.get'); 

// Marks Entry Grade 

Route::get('marks/grade/view', [GradeController::class, 'MarksGradeView'])->name('marks.entry.grade');

Route::get('marks/grade/add', [GradeController::class, 'MarksGradeAdd'])->name('marks.grade.add');

Route::post('marks/grade/store', [GradeController::class, 'MarksGradeStore'])->name('store.marks.grade');

Route::get('marks/grade/edit/{id}', [GradeController::class, 'MarksGradeEdit'])->name('marks.grade.edit');

Route::post('marks/grade/update/{id}', [GradeController::class, 'MarksGradeUpdate'])->name('update.marks.grade');

// Student Result Report Routes 
Route::get('allstudent/result/view', [ResultReportController::class, 'ResultView'])->name('student.result.view');


Route::get('allstudent/result/get', [ResultReportController::class, 'ResultGet'])->name('report.student.result.get');


}); 
 

Route::get('marks/getsubject', [DefaultController::class, 'GetSubject'])->name('marks.getsubject');

Route::get('student/marks/getstudents', [DefaultController::class, 'GetStudents'])->name('student.marks.getstudents');




        
    }); 

}); 
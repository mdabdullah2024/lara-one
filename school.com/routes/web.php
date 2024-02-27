<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\backend\authController;
use App\Http\Controllers\backend\DashboardController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\AdminController;
use App\Http\Controllers\backend\TeacherController;
use App\Http\Controllers\backend\StudentController;
use App\Http\Controllers\backend\ParentController;
use App\Http\Controllers\backend\ClassController;
use App\Http\Controllers\backend\SubjectController;
use App\Http\Controllers\backend\AssignClassTeacherController;
use App\Http\Controllers\backend\ClassSubjectController;
use App\Http\Controllers\backend\ClassTimetableController;
use App\Http\Controllers\backend\ExaminationController;
use App\Http\Controllers\backend\CalendarController;
use App\Http\Controllers\backend\AttendanceController;
use App\Http\Controllers\backend\CommunicateController;
use App\Http\Controllers\backend\HomeworkController;
use App\Http\Controllers\backend\FeesCollectionController;
use App\Http\Controllers\backend\ChatController;



Route::get('/',[authController::class,'login'])->name('auth.login');
Route::post('login',[authController::class,'authLogin'])->name('auth.login.post');
Route::get('/logout',[authController::class,'authLogout'])->name('auth.logout');
Route::get('/forgot-password',[authController::class,'forgotPassword'])->name('forgot.password');
Route::post('/forgot-password',[authController::class,'ForgotPasswordPost'])->name('forgot.password.post');
Route::get('/reset/{token}',[authController::class,'reset'])->name('forgot.password.reset');
Route::post('/reset/{token}',[authController::class,'PostReset'])->name('forgot.password.reset.post');


Route::group(['middleware'=>'common'],function(){

    Route::get('chat',[ChatController::class,'Chat']);
    Route::post('submit_message',[ChatController::class,'SubmitMessage']);
    Route::post('get_chat_windows',[ChatController::class,'GetChatWindows']);
    Route::post('get_chat_search_user',[ChatController::class,'get_chat_search_user']);
});



Route::group(['middleware'=>'admin'],function(){
    
    //admin url
    Route::get('admin/dashboard',[DashboardController::class,'dashboard'])->name('admin.dashboard'); 
    Route::get('/admin/admin/list',[AdminController::class,'list'])->name('admin.admin.list');
    Route::get('/admin/admin/add',[AdminController::class,'add'])->name('admin.admin.add');
    Route::post('/admin/admin/add',[AdminController::class,'store'])->name('admin.admin.store');
    Route::get('/admin/admin/edit/{id}',[AdminController::class,'edit'])->name('admin.admin.edit');
    Route::post('/admin/admin/update/{id}',[AdminController::class,'update'])->name('admin.admin.udate');
    Route::get('/admin/admin/delete/{id}',[AdminController::class,'delete'])->name('admin.admin.delete');

    //Teacher url
    Route::get('/admin/teacher/list',[TeacherController::class,'list'])->name('admin.teacher.list');
    Route::get('/admin/teacher/add',[TeacherController::class,'add'])->name('admin.teacher.add');
    Route::post('/admin/teacher/add',[TeacherController::class,'store'])->name('admin.teacher.store');
    Route::get('/admin/teacher/edit/{id}',[TeacherController::class,'edit'])->name('admin.teacher.edit');
    Route::post('/admin/teacher/update/{id}',[TeacherController::class,'update'])->name('admin.teacher.update');
    Route::get('/admin/teacher/delete/{id}',[TeacherController::class,'delete'])->name('admin.teacher.delete');

    //student url
    Route::get('/admin/student/list',[StudentController::class,'list'])->name('admin.student.list');
    Route::get('/admin/student/add',[StudentController::class,'add'])->name('admin.student.add');
    Route::post('/admin/student/store',[StudentController::class,'store'])->name('admin.student.store');
    Route::get('/admin/student/edit/{id}',[StudentController::class,'edit'])->name('admin.student.edit');
    Route::post('/admin/student/update/{id}',[StudentController::class,'update'])->name('admin.student.update');
    Route::get('/admin/student/delete/{id}',[StudentController::class,'delete'])->name('admin.student.delete');

    //parent url
    Route::get('/admin/parent/list',[ParentController::class,'list'])->name('admin.parent.list');
    Route::get('/admin/parent/add',[ParentController::class,'add'])->name('admin.parent.add');
    Route::post('/admin/parent/store',[ParentController::class,'store'])->name('admin.parent.store');
    Route::get('/admin/parent/edit/{id}',[ParentController::class,'edit'])->name('admin.parent.edit');
    Route::post('/admin/parent/update/{id}',[ParentController::class,'update'])->name('admin.parent.update');
    Route::get('/admin/parent/delete/{id}',[ParentController::class,'delete'])->name('admin.parent.delete');
    Route::get('/admin/parent/my-student/{id}',[ParentController::class,'myStudent'])->name('admin.parent.my_student');
    Route::get('/admin/parent/assing-student-to-parent/{student_id}/{parent_id}',[ParentController::class,'AssignStudentParent'])->name('admin.parent.assign_student_to_parent');
    Route::get('/admin/parent/assing-student-to-parent-delete/{student_id}',[ParentController::class,'AssignStudentParentDelete'])->name('admin.parent.assign_student_to_parent_delete');



    //class url

    Route::get('/admin/class/list',[ClassController::class,'list'])->name('admin.class.list');
    Route::get('/admin/class/add',[ClassController::class,'add'])->name('admin.class.add');
    Route::post('/admin/class/add',[ClassController::class,'store'])->name('admin.class.store');
    Route::get('/admin/class/edit/{id}',[ClassController::class,'edit'])->name('admin.class.edit');
    Route::get('/admin/class/update/{id}',[ClassController::class,'update'])->name('admin.class.udate');
    Route::get('/admin/class/delete/{id}',[ClassController::class,'delete'])->name('admin.class.delete');

    //subject url

    Route::get('/admin/subject/list',[SubjectController::class,'list'])->name('admin.subject.list');
    Route::get('/admin/subject/add',[SubjectController::class,'add'])->name('admin.subject.add');
    Route::post('/admin/subject/add',[SubjectController::class,'store'])->name('admin.subject.store');
    Route::get('/admin/subject/edit/{id}',[SubjectController::class,'edit'])->name('admin.subject.edit');
    Route::get('/admin/subject/update/{id}',[SubjectController::class,'update'])->name('admin.subject.udate');
    Route::get('/admin/subject/delete/{id}',[SubjectController::class,'delete'])->name('admin.subject.delete');

    //Class subject url

    Route::get('/admin/class-subject/list',[ClassSubjectController::class,'list'])->name('admin.class_subject.list');
    Route::get('/admin/class-subject/add',[ClassSubjectController::class,'add'])->name('admin.class_subject.add');
    Route::post('/admin/class-subject/add',[ClassSubjectController::class,'store'])->name('admin.class_subject.store');
    Route::get('/admin/class-subject/edit/{id}',[ClassSubjectController::class,'edit'])->name('admin.class_subject.edit');
    Route::get('/admin/class-subject/update',[ClassSubjectController::class,'update'])->name('admin.class_subject.update');
    Route::get('/admin/class-subject/delete/{id}',[ClassSubjectController::class,'delete'])->name('admin.class_subject.delete');
    Route::get('/admin/class-subject/editSingle/{id}',[ClassSubjectController::class,'editSingle'])->name('admin.class_subject.editSingle');
    Route::post('/admin/class-subject/updateSingle{id}',[ClassSubjectController::class,'updateSingle'])->name('admin.class_subject.updateSingle');

 // Class Timetable url  
Route::get('/admin/class_timetable/list',[ClassTimetableController::class,'list'])->name('admin.class_timetable.list');
Route::post('/admin/class_timetable/get_subject',[ClassTimetableController::class,'getSubject'])->name('admin.class_timetable.get_subject');
Route::post('/admin/class_timetable/add',[ClassTimetableController::class,'storeUpdate'])->name('admin.class_timetable.add');


 //Assign Class Teacher url

    Route::get('/admin/assign-class-teachert/list',[AssignClassTeacherController::class,'list'])->name('admin.assign_class_teacher.list');
    Route::get('/admin/assign-class-teachert/add',[AssignClassTeacherController::class,'add'])->name('admin.assign_class_teacher.add');
    Route::post('/admin/assign-class-teachert/add',[AssignClassTeacherController::class,'store'])->name('admin.assign_class_teacher.store');
    Route::get('/admin/assign-class-teachert/edit/{id}',[AssignClassTeacherController::class,'edit'])->name('admin.assign_class_teacher.edit');
    Route::post('/admin/assign-class-teachert/edit/{id}',[AssignClassTeacherController::class,'update'])->name('admin.assign_class_teacher.update');
    Route::get('/admin/assign-class-teachert/delete/{id}',[AssignClassTeacherController::class,'delete'])->name('admin.assign_class_teacher.delete');

    Route::get('/admin/assign-class-teachert/edit_signle/{id}',[AssignClassTeacherController::class,'editSingle'])->name('admin.assign_class_teacher.edit_single');
    Route::post('/admin/assign-class-teachert/edit_signle/{id}',[AssignClassTeacherController::class,'updateSingle'])->name('admin.assign_class_teacher.update_single');

//Examinations url
    
    Route::get('/admin/examinations/exam/list',[ExaminationController::class,'Examlist']);
    Route::get('/admin/examinations/exam/add',[ExaminationController::class,'add']);
    Route::post('/admin/examinations/exam/add',[ExaminationController::class,'store']);
    Route::get('/admin/examinations/exam/edit/{id}',[ExaminationController::class,'edit']);
    Route::post('/admin/examinations/exam/update/{id}',[ExaminationController::class,'update']);
    Route::get('/admin/examinations/exam/delete/{id}',[ExaminationController::class,'delete']);

//Examinations Schedule url
    
    Route::get('admin/examinations/exam_schedule/list',[ExaminationController::class,'examSchedulelist']);
    Route::post('admin/examinations/exam_schedule/list',[ExaminationController::class,'examSchedulelistInsert']);
    Route::get('admin/examinations/exam_schedule/add',[ExaminationController::class,'examScheduleAdd']);
    Route::post('admin/examinations/exam_schedule/add',[ExaminationController::class,'examScheduleStore']);
    Route::get('admin/examinations/exam_schedule/edit/{id}',[ExaminationController::class,'examScheduleEdit']);
    Route::post('admin/examinations/exam_schedule/update/{id}',[ExaminationController::class,'examScheduleUpdate']);
    Route::get('admin/examinations/exam_schedule/delete/{id}',[ExaminationController::class,'examScheduleDelete']);


//Examinations Mark Register url
    Route::get('/admin/examinations/mark_register/list',[ExaminationController::class,'examMarkRegister']);
    Route::post('/admin/examinations/submit_mark_register',[ExaminationController::class,'examMarkRegisterSubmit']);
    Route::post('/admin/examinations/single_submit_mark_register',[ExaminationController::class,'examMarkRegisterSubmitSingle']);
    Route::get('/admin/my_exam_result/print',[ExaminationController::class,'myExamResultPrint']);

//Marks Grade 
    Route::get('/admin/examinations/mark_grade/list',[ExaminationController::class,'examMarkGradeList']);
    Route::get('/admin/examinations/mark_grade/add',[ExaminationController::class,'examMarkGradeAdd']);
    Route::post('/admin/examinations/mark_grade/add',[ExaminationController::class,'examMarkGradeStore']);
    Route::get('/admin/examinations/mark_grade/edit/{id}',[ExaminationController::class,'examMarkGradeEdit']);
    Route::post('/admin/examinations/mark_grade/edit/{id}',[ExaminationController::class,'examMarkGradeUpdate']);
    Route::get('/admin/examinations/mark_grade/delete/{id}',[ExaminationController::class,'examMarkGradeDelete']);

//Attendance Admin for Student
    Route::get('/admin/attendance/student_attendance',[AttendanceController::class,'StudentAttendance']);
    Route::post('/admin/attendance/student/save',[AttendanceController::class,'StudentAttendanceSave']);
    Route::get('/admin/attendance/reports',[AttendanceController::class,'StudentAttendanceReports']);
//communicate routes
    Route::get('/admin/communicate/notice_board',[CommunicateController::class,'NoticeBoard']);
    Route::get('/admin/communicate/notice_board/add',[CommunicateController::class,'AddNoticeBoard']);
    Route::post('/admin/communicate/notice_board/add',[CommunicateController::class,'InsertNoticeBoard']);
    Route::get('/admin/communicate/notice_board/edit/{id}',[CommunicateController::class,'EditNoticeBoard']);
    Route::post('/admin/communicate/notice_board/edit/{id}',[CommunicateController::class,'UpdateNoticeBoard']);
    Route::get('/admin/communicate/notice_board/delete/{id}',[CommunicateController::class,'DeleteNoticeBoard']);
    Route::get('/admin/communicate/send_email',[CommunicateController::class,'SendEmail']);
    Route::post('/admin/communicate/send_email',[CommunicateController::class,'SendEmailUser']);
    Route::get('/admin/communicate/search_user',[CommunicateController::class,'SearchUser']);
//homework routes
    Route::get('/admin/homework/homework',[HomeworkController::class,'Homework']);
    Route::post('/admin/ajax_get_subject',[HomeworkController::class,'AjaxGetSubject']);
    Route::get('/admin/homework/homework/add',[HomeworkController::class,'HomeworkAdd']);
    Route::post('/admin/homework/homework/add',[HomeworkController::class,'InsertHomework']);
    Route::get('/admin/homework/homework/edit/{id}',[HomeworkController::class,'EditHomework']);
    Route::post('/admin/homework/homework/edit/{id}',[HomeworkController::class,'UpdateHomework']);
    Route::get('/admin/homework/homework/delete/{id}',[HomeworkController::class,'DeleteHomework']);
    Route::get('/admin/homework/submitted_homework/{id}',[HomeworkController::class,'SubmittedHomework']);
    Route::get('/admin/homework/homework_report',[HomeworkController::class,'HomeworkReports']);

//Fees Collection
    Route::get('/admin/fees_collection/collect_fees',[FeesCollectionController::class,'CollectFees']);
    Route::get('/admin/fees_collection/collect_fees/add_fees/{student_id}',[FeesCollectionController::class,'CollectFeesAdd']);
    Route::post('/admin/fees_collection/collect_fees/add_fees/{student_id}',[FeesCollectionController::class,'CollectFeesAddSubmit']);
    Route::get('/admin/fees_collection/collect_fees_reports',[FeesCollectionController::class,'CollectFeesReports']);


//settings
    Route::get('/admin/settings',[UserController::class,'Settings']);
    Route::post('/admin/settings',[UserController::class,'SettingsUpdate']);



//MY ACCCOUNT
    Route::get('/admin/myacount',[UserController::class,'myAccountAdmin'])->name('admin.myacount.list');
    Route::post('/admin/myacount',[UserController::class,'updateMyAccountAdmin'])->name('admin.myacount.list.post');

//change Password url
    Route::get('/admin/change_password',[UserController::class,'change_password'])->name('admin.change_password.add');
    Route::post('/admin/change_password',[UserController::class,'change_passwordPost'])->name('admin.change_password.post');





});

Route::group(['middleware'=>'teacher'],function(){
    Route::get('teacher/dashboard',[DashboardController::class,'dashboard'])->name('teacher.dashboard'); 

    //My Student url
    Route::get('/teacher/my_student',[StudentController::class,'MyStudentTeacher'])->name('teacher.my_student'); 


    //my subject and class url
    Route::get('teacher/my_class_subject',[AssignClassTeacherController::class,'MyClassSubject'])->name('teacher.my_class_subject');
    
    //MY ACCCOUNT
    Route::get('/teacher/myacount',[UserController::class,'myAccount'])->name('teacher.myacount.list');
    Route::post('/teacher/myacount',[UserController::class,'updateMyAccount'])->name('teacher.myacount.list.post');

//MY Exam Timetable
    Route::get('/teacher/my_exam_timetable',[ExaminationController::class,'MyExamTimetableTeacher']);

//MY Class Timetable
    Route::get('/teacher/my_class_subject/class_timetable/{class_id}/{subject_id}',[ClassTimetableController::class,'MyTimetableTeacher']);
//MY Calendar
    Route::get('/teacher/my_calendar',[CalendarController::class,'MyCalendarTeacher'])->name('teacher.my_calendar.list');

//Marks Register url
    Route::get('/teacher/marks_register',[ExaminationController::class,'marksRegisterTeacher'])->name('teacher.marks_register.list');
    Route::post('/teacher/submit_mark_register',[ExaminationController::class,'examMarkRegisterSubmit']);
    Route::post('/teacher/single_submit_mark_register',[ExaminationController::class,'examMarkRegisterSubmitSingle']);
    Route::get('/teacher/my_exam_result/print',[ExaminationController::class,'myExamResultPrint']);

//Attendance teacher for Student
    Route::get('/teacher/attendance/student_attendance',[AttendanceController::class,'StudentAttendanceTeacher']);
    Route::post('/teacher/attendance/student/save',[AttendanceController::class,'StudentAttendanceTeacherSave']);
    Route::get('/teacher/attendance/reports',[AttendanceController::class,'StudentAttendanceTeacherReport']);

//homework routes
    Route::get('/teacher/homework/homework',[HomeworkController::class,'HomeworkTeacher']);
    Route::post('/teacher/ajax_get_subject',[HomeworkController::class,'AjaxGetSubject']);
    Route::get('/teacher/homework/homework/add',[HomeworkController::class,'HomeworkAddTeacher']);
    Route::post('/teacher/homework/homework/add',[HomeworkController::class,'InsertHomeworkTeacher']);
    Route::get('/teacher/homework/homework/edit/{id}',[HomeworkController::class,'EditHomeworkTeacher']);
    Route::post('/teacher/homework/homework/edit/{id}',[HomeworkController::class,'UpdateHomeworkTeacher']);
    Route::get('/teacher/homework/homework/delete/{id}',[HomeworkController::class,'DeleteHomeworkTeacher']);
    Route::get('/teacher/homework/homework/submitted/{id}',[HomeworkController::class,'SubmittedHomeworkTeacher']);




//my noticeboard
    Route::get('/teacher/my_notice_board',[CommunicateController::class,'MyNoticeBoardTeacher']);
    //change Password url
    Route::get('/teacher/change_password',[UserController::class,'change_password'])->name('teacher.change_password.add');
    Route::post('/teacher/change_password',[UserController::class,'change_passwordPost'])->name('teacher.change_password.post');
});

Route::group(['middleware'=>'student'],function(){
    Route::get('student/dashboard',[DashboardController::class,'dashboard'])->name('student.dashboard');
Route::get('/student/fees_collection',[FeesCollectionController::class,'CollectFeesStudent']);
Route::post('/student/fees_collection',[FeesCollectionController::class,'CollectFeesStudentSubmit']);
Route::get('student/paypal/payment-error',[FeesCollectionController::class,'PaymentError']);
Route::get('student/paypal/payment-success',[FeesCollectionController::class,'PaymentSuccess']);

//MY Calendar
    Route::get('/student/my_calendar',[CalendarController::class,'MyCalendar'])->name('student.my_calendar.list');

//MY Subject
    Route::get('/student/mysubject',[SubjectController::class,'MySubject'])->name('student.mysubject.list');

//MY exam Timetable
    Route::get('/student/my_exam_timetable/list',[ExaminationController::class,'MyExamTimetable']);
//My Exam  Result url
    Route::get('/student/my_exam_result',[ExaminationController::class,'myExamResult']);
    Route::get('/student/my_exam_result/print',[ExaminationController::class,'myExamResultPrint']);

    // Route::post('/student/submit_mark_register',[ExaminationController::class,'examMarkRegisterSubmit']);
    // Route::post('/student/single_submit_mark_register',[ExaminationController::class,'examMarkRegisterSubmitSingle']);

//MY Class Timetable
    Route::get('/student/my_timetable/list',[ClassTimetableController::class,'MyTimetable']);

//My Attendance
    Route::get('/student/my_attendance',[AttendanceController::class,'myAttendanceReports']);

//My Notice Board
    Route::get('/student/my_notice_board',[CommunicateController::class,'MyNoticeBoardStudent']);
//homework
    Route::get('/student/my_homework',[HomeworkController::class,'HomeworkStudent']);
    Route::get('/student/my_homework_submit/{id}',[HomeworkController::class,'MyHomeworkSubmit']);
    Route::post('/student/my_homework_submit/{id}',[HomeworkController::class,'MyHomeworkSubmitInsert']);
    Route::get('/student/my_submitted_homework',[HomeworkController::class,'HomeworkSubmittedStudent']);

    //MY ACCCOUNT
    Route::get('/student/myacount',[UserController::class,'myAccountStudent'])->name('student.myacount.list');
    Route::post('/student/myacount',[UserController::class,'updateMyAccountStudent'])->name('student.myacount.list.post');

    //change Password url
    Route::get('/student/change_password',[UserController::class,'change_password'])->name('student.change_password.add');
    Route::post('/student/change_password',[UserController::class,'change_passwordPost'])->name('student.change_password.post'); 
});

Route::group(['middleware'=>'parent'],function(){
    Route::get('parent/dashboard',[DashboardController::class,'dashboard'])->name('parent.dashboard');
    //MY ACCCOUNT
    Route::get('/parent/myacount',[UserController::class,'myAccountParent'])->name('parent.myacount.list');
    Route::post('/parent/myacount',[UserController::class,'updateMyAccountParent'])->name('parent.myacount.list.post');

    //change Password url
    Route::get('/parent/change_password',[UserController::class,'change_password'])->name('parent.change_password.add');
    Route::post('/parent/change_password',[UserController::class,'change_passwordPost'])->name('parent.change_password.post');

    //My Children Password url
    Route::get('/parent/my-children/',[ParentController::class,'myChildren'])->name('parent.children.list');  
    Route::get('/parent/my-children/{student_id}',[SubjectController::class,'myChildrenSubject'])->name('parent.children.subject.list');

    //children exam timetable
    Route::get('/parent/my-children/exam-timetable/{student_id}',[ExaminationController::class,'myChildrenExamTimetable']);

    //children calendar
    Route::get('/parent/my-children/my-calendar/{student_id}',[CalendarController::class,'myCalendarParent']);


    Route::get('/parent/my-children/class_timetable/{class_id}/{subject_id}/{student_id}',[ClassTimetableController::class,'myChildrenClassTimetable']); 

//children Exam Result
    Route::get('/parent/my-children/exam_result/{student_id}',[ExaminationController::class,'myChildrenExamResult']);
    Route::get('/parent/my_exam_result/print',[ExaminationController::class,'myExamResultPrint']);
// Children Attendance
    Route::get('/parent/my-children/my_attendance/{student_id}',[AttendanceController::class,'myChildrenAttendance']);

//my noticeboard
    Route::get('/parent/my_notice_board',[CommunicateController::class,'MyNoticeBoardParent']);
//homework
    Route::get('/parent/my-children/homework/{id}',[HomeworkController::class,'MychildHomework']);
    Route::get('/parent/my-children/homework/submitted/{id}',[HomeworkController::class,'MychildSubmittedHomework']);
//my child fees collection
Route::get('/parent/my-children/fees_collection/{student_id}',[FeesCollectionController::class,'myChildFeesCollection']);
Route::post('/parent/my-children/fees_collection/{student_id}',[FeesCollectionController::class,'myChildFeesCollectionSubmit']);


});
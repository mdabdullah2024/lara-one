
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      @if(Auth::user()->user_type==1)
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <a href="{{ url('/admin/myacount') }}" class="d-block">
            <img src="{{url('public/upload/profile_images/',Auth::User()->profile_pic)}}" class="img-circle " width="50px" height="50px" alt="User Image">
            </a>
          </div>
          <div class="info">
            <a href="{{ url('/admin/myacount') }}" class="d-block">{{Auth::user()->name}} {{Auth::user()->last_name}}</a>
          </div>
      </div>
      @endif
      @if(Auth::user()->user_type==2)
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <a href="{{ url('/teacher/myacount') }}" class="d-block">
            <img src="{{url('public/upload/profile_images/',Auth::User()->profile_pic)}}" class="img-circle " width="50px" height="50px" alt="User Image">
            </a>
          </div>
          <div class="info">
            <a href="{{ url('/teacher/myacount') }}" class="d-block">{{Auth::user()->name}} {{Auth::user()->last_name}}</a>
          </div>
      </div>
      @endif
      @if(Auth::user()->user_type==3)
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <a href="{{ url('/student/myacount') }}" class="d-block">
            <img src="{{url('public/upload/profile_images/',Auth::User()->profile_pic)}}" class="img-circle " width="50px" height="50px" alt="User Image">
            </a>
          </div>
          <div class="info">
            <a href="{{ url('/student/myacount') }}" class="d-block">{{Auth::user()->name}} {{Auth::user()->last_name}}</a>
          </div>
      </div>
      @endif
      @if(Auth::user()->user_type==4)
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <a href="{{ url('/parent/myacount') }}" class="d-block">
            <img src="{{url('public/upload/profile_images/',Auth::User()->profile_pic)}}" class="img-circle " width="50px" height="50px" alt="User Image">
            </a>
          </div>
          <div class="info">
            <a href="{{ url('/parent/myacount') }}" class="d-block">{{Auth::user()->name}} {{Auth::user()->last_name}}</a>
          </div>
      </div>
      @endif
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          @if(Auth::user()->user_type==1)
          <li class="nav-item">
            <a href="{{url('admin/dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/admin/admin/list')}}" class="nav-link @if(Request::segment(2) == 'admin') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Admin
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/admin/teacher/list')}}" class="nav-link @if(Request::segment(2) == 'teacher') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Teacher
                
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/admin/student/list')}}" class="nav-link @if(Request::segment(2) == 'student') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Student
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('/admin/parent/list')}}" class="nav-link @if(Request::segment(2) == 'parent') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Parent
              </p>
            </a>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'class-subject' || Request::segment(2) == 'assign-class-teachert' ||Request::segment(2) == 'class_timetable') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'class' || Request::segment(2) == 'subject' || Request::segment(2) == 'class-subject' || Request::segment(2) == 'assign-class-teachert' ||Request::segment(2) == 'class_timetable') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Academics
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/class/list')}}" class="nav-link @if(Request::segment(2) == 'class') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Class</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/subject/list')}}" class="nav-link @if(Request::segment(2) == 'subject') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Subject</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.class_subject.list')}}" class="nav-link @if(Request::segment(2) == 'class-subject') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assign Subject</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.class_timetable.list')}}" class="nav-link @if(Request::segment(2) == 'class_timetable') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Class Timetable</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('admin.assign_class_teacher.list')}}" class="nav-link @if(Request::segment(2) == 'assign-class-teachert') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Assign Class Teacher</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'examinations') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'examinations') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Examinations
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/examinations/exam/list')}}" class="nav-link @if(Request::segment(3) == 'exam') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Exam</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/examinations/exam_schedule/list')}}" class="nav-link @if(Request::segment(3) == 'exam_schedule') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Exam Schedule</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('/admin/examinations/mark_register/list')}}" class="nav-link @if(Request::segment(3) == 'mark_register') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Mark Register</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/examinations/mark_grade/list')}}" class="nav-link @if(Request::segment(3) == 'mark_grade') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Marks Grade</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'attendance') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'attendance') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Attendance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/attendance/student_attendance')}}" class="nav-link @if(Request::segment(3) == 'student_attendance') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Attendance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/attendance/reports')}}" class="nav-link @if(Request::segment(3) == 'reports') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attendance Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'communicate') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'communicate') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Communicate
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/communicate/notice_board')}}" class="nav-link @if(Request::segment(3) == 'notice_board') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Notice Board</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/communicate/send_email')}}" class="nav-link @if(Request::segment(3) == 'send_email') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Send Email</p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item @if(Request::segment(2) == 'homework') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'homework') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Homework
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/homework/homework')}}" class="nav-link @if(Request::segment(3) == 'homework') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Homework</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/homework/homework_report')}}" class="nav-link @if(Request::segment(3) == 'homework_report') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Homework Reports</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'fees_collection') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'fees_collection') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Fees Collection
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/admin/fees_collection/collect_fees')}}" class="nav-link @if(Request::segment(3) == 'collect_fees') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collect Fees</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/admin/fees_collection/collect_fees_reports')}}" class="nav-link @if(Request::segment(3) == 'collect_fees_reports') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Collect Fees Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.myacount.list')}}" class="nav-link @if(Request::segment(2) == 'myacount') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/settings')}}" class="nav-link @if(Request::segment(2) == 'settings') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Settings
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('admin.change_password.add')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
          @elseif(Auth::user()->user_type==2)
          
          <li class="nav-item">
            <a href="{{route('teacher.dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('teacher.my_student')}}" class="nav-link @if(Request::segment(2) == 'my_student') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Students
              </p>
            </a>
          </li>
          
          
          <li class="nav-item">
            <a href="{{route('teacher.my_class_subject')}}" class="nav-link @if(Request::segment(2) == 'my_class_subject') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Class & Subject
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/my_exam_timetable')}}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Exam Timetable
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('teacher/my_calendar')}}" class="nav-link @if(Request::segment(2) == 'my_calendar') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Calendar
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('teacher/marks_register')}}" class="nav-link @if(Request::segment(2) == 'marks_register') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Marks Register
              </p>
            </a>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'attendance') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'attendance') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Attendance
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/teacher/attendance/student_attendance')}}" class="nav-link @if(Request::segment(3) == 'student_attendance') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Student Attendance</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('/teacher/attendance/reports')}}" class="nav-link @if(Request::segment(3) == 'reports') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Attendance Report</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item @if(Request::segment(2) == 'homework') menu-open @endif ">
            <a href="#" class="nav-link @if(Request::segment(2) == 'homework') active @endif">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Homework
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('/teacher/homework/homework')}}" class="nav-link @if(Request::segment(3) == 'homework') active @endif">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Homework</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{url('teacher/my_notice_board')}}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Notice Board 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('teacher.myacount.list')}}" class="nav-link @if(Request::segment(2) == 'myacount') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('teacher.change_password.add')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>

          @elseif(Auth::user()->user_type==3)
          <li class="nav-item">
            <a href="{{route('student.dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/fees_collection')}}" class="nav-link @if(Request::segment(2) == 'fees_collection') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Fees Collection
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_calendar')}}" class="nav-link @if(Request::segment(2) == 'my_calendar') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Calendar
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('student.mysubject.list')}}" class="nav-link @if(Request::segment(2) == 'mysubject') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Subjects
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_timetable/list')}}" class="nav-link @if(Request::segment(2) == 'my_timetable') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Class Timetable
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_exam_timetable/list')}}" class="nav-link @if(Request::segment(2) == 'my_exam_timetable') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Exam Timetable
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('student/my_exam_result')}}" class="nav-link @if(Request::segment(2) == 'my_exam_result') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Exam Result
              </p>
            </a>
          </li>

          
          <li class="nav-item">
            <a href="{{url('student/my_attendance')}}" class="nav-link @if(Request::segment(2) == 'my_attendance') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Attendance 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('student/my_notice_board')}}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Notice Board 
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('student/my_homework')}}" class="nav-link @if(Request::segment(2) == 'my_homework') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Homework 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('student/my_submitted_homework')}}" class="nav-link @if(Request::segment(2) == 'my_submitted_homework') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Submitted HW 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('student.myacount.list')}}" class="nav-link @if(Request::segment(2) == 'myacount') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Account
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('student.change_password.add')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>

          @elseif(Auth::user()->user_type==4)
          <li class="nav-item">
            <a href="{{route('parent.dashboard')}}" class="nav-link @if(Request::segment(2) == 'dashboard') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('/parent/my-children')}}" class="nav-link @if(Request::segment(2) == 'my-children') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Children
              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="{{url('parent/my_notice_board')}}" class="nav-link @if(Request::segment(2) == 'my_notice_board') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Notice Board 
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{route('parent.myacount.list')}}" class="nav-link @if(Request::segment(2) == 'myacount') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                My Account
              </p>
            </a>
          </li>
          
          <li class="nav-item">
            <a href="{{route('parent.change_password.add')}}" class="nav-link @if(Request::segment(2) == 'change_password') active @endif">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Change Password
              </p>
            </a>
          </li>
          @endif

          <li class="nav-item">
            <a href="{{route('auth.logout')}}" class="nav-link">
              <i class="nav-icon fas fa-bars"></i>
              <p>
                Logout
              </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
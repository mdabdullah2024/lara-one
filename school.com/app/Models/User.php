<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;
use Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function OnlineUser()
    {
        return Cache::has('OnlineUser'.$this->id);
    }


    static public function TotalUser($user)
    {
        return self::select('users.*')
                    ->where('users.user_type','=',$user)
                    ->where('users.is_delete','=',0)
                    ->count();
    }




    static public function AllUser($user_type)
    {
        return self::select('users.*')
                ->where('users.user_type','=',$user_type)
                ->where('users.is_delete','=',0)
                ->get();
    }

    static public function getSingle($id)
    {
        return self::find($id);
    }

    
    static public function getStudentClassPayment($student_id)
    {
        return self::select('users.*','class.amounts as class_amounts','class.name as class_name','class.id as class_id')
                     ->join('class','class.id','users.class_id')
                     ->where('users.id','=',$student_id)
                     ->first();
    }

    static public function getPaidAmounts($student_id,$class_id)
    {
        return StudentAddFeesModel::paidAmount($student_id,$class_id);
    }

    static public function SearchUser($search)
    {
        $return = self::select('users.*');
        $return = $return->where(function($query) use ($search){
            $query->where('users.name','like','%'.$search.'%')
            ->orWhere('users.last_name','like','%'.$search.'%');
        })
        ->where('is_delete','=',0)
        ->limit(10)
        ->get();
        return $return;

    }
    static function getAdmin()
    {
        $return = self::select('users.*')
                ->where('user_type','=',1)
                ->where('is_delete','=',0);
                if (!empty(Request::get('name'))) {
                    $return = $return->where('name','like','%'.Request::get('name').'%');
                }
                if (!empty(Request::get('email'))) {
                    $return = $return->where('email','like','%'.Request::get('email').'%');
                }
                if (!empty(Request::get('date'))) {
                    $return = $return->whereDate('created_at','=',Request::get('date'));
                }
        $return = $return->orderBy('id','desc')->paginate(20);
        return $return;
    }

    static function getTeacher()
    {
        $return = self::select('users.*')
                ->where('user_type','=',2)
                ->where('is_delete','=',0);
                if (!empty(Request::get('name'))) {
                    $return = $return->where('name','like','%'.Request::get('name').'%');
                }
                if (!empty(Request::get('last_name'))) {
                    $return = $return->where('last_name','like','%'.Request::get('last_name').'%');
                }
                if (!empty(Request::get('email'))) {
                    $return = $return->where('email','like','%'.Request::get('email').'%');
                }
                if (!empty(Request::get('id'))) {
                    $return = $return->where('id','=',Request::get('id'));
                }
        $return = $return->orderBy('id','desc')->paginate(20);
        return $return;
    }

    static function getTeacherClass()
    {
        $return = self::select('users.*')
                ->where('user_type','=',2)
                ->where('is_delete','=',0);
        $return = $return->orderBy('id','desc')->get();
        return $return;
    }

    

    

    static function getParent()
    {
        $return = self::select('users.*')
                ->where('user_type','=',4)
                ->where('is_delete','=',0);

                if (!empty(Request::get('name'))) {
                    $return = $return->where('users.name','like','%'.Request::get('name').'%');
                }
                if (!empty(Request::get('email'))) {
                    $return = $return->where('users.email','like','%'.Request::get('email').'%');
                }
                if (!empty(Request::get('mobile_number'))) {
                    $return = $return->where('users.mobile_number','=',Request::get('mobile_number'));
                }

                if (!empty(Request::get('occupation'))) {
                    $return = $return->where('users.occupation','=',Request::get('occupation'));
                }
        $return = $return->orderBy('id','desc')->paginate(20);
        return $return;
    }

    

static function getFeesCollectionStudent()
    {
        $return = self::select('users.*','class.name as class_name','class.amounts as class_amounts')
                ->join('class','class.id','=','users.class_id')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0);
                if (!empty(Request::get('class_id'))) {
                    $return = $return->where('users.class_id','=',Request::get('class_id'));
                }
                if (!empty(Request::get('student_id'))) {
                    $return = $return->where('users.id','=',Request::get('student_id'));
                }
                if (!empty(Request::get('first_name'))) {
                    $return = $return->where('users.name','like','%'.Request::get('first_name').'%');
                }
                if (!empty(Request::get('last_name'))) {
                    $return = $return->where('users.last_name','like','%'.Request::get('last_name').'%');
                }
        $return = $return->orderBy('users.id','desc')->paginate(20);
        return $return;
    }
    static function getStudent()
    {
        $return = self::select('users.*','class.name as class_id_name','parent.name as parent_name','parent.last_name as parent_lastname')
                ->join('users as parent','parent.id','=','users.parent_id','left')
                ->join('class','class.id','=','users.class_id','left')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0);
                if (!empty(Request::get('name'))) {
                    $return = $return->where('users.name','like','%'.Request::get('name').'%');
                }
                if (!empty(Request::get('email'))) {
                    $return = $return->where('users.email','like','%'.Request::get('email').'%');
                }
                if (!empty(Request::get('admission_number'))) {
                    $return = $return->where('users.admission_number','=',Request::get('admission_number'));
                }

                if (!empty(Request::get('roll_number'))) {
                    $return = $return->where('users.roll_number','=',Request::get('roll_number'));
                }
                if (!empty(Request::get('class_id'))) {
                    $return = $return->where('users.class_id','=',Request::get('class_id'));
                }
        $return = $return->orderBy('users.id','desc')->paginate(20);
        return $return;
    }


    static public function getStudentClass($class_id)
    {
        return  self::select('users.id','users.name','users.last_name')
                ->join('class','class.id','=','users.class_id','left')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0)
                ->where('users.class_id','=',$class_id)
                ->orderBy('users.id','desc')->get();
    }

    static public function getStudentClassSingle($class_id)
    {
        return  self::select('users.class_id','class.name as class_name')
                ->join('class','class.id','=','users.class_id','left')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0)
                ->where('users.class_id','=',$class_id)
                ->first();
    }


    static function getSearchStudent()
    {
        if (!empty(Request::get('id')) || !empty(Request::get('name')) || !empty(Request::get('last_name')) || !empty(Request::get('email'))) {
            $return = self::select('users.*','class.name as class_id_name','parent.name as parent_name')
                ->join('users as parent','parent.id','=','users.parent_id','left')
                ->join('class','class.id','=','users.class_id')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0);
                if (!empty(Request::get('id'))) {
                    $return = $return->where('users.id','=',Request::get('id'));
                }
                if (!empty(Request::get('name'))) {
                    $return = $return->where('users.name','like','%'.Request::get('name').'%');
                }
                if (!empty(Request::get('last_name'))) {
                    $return = $return->where('users.last_name','like','%'.Request::get('last_name').'%');
                }
                if (!empty(Request::get('email'))) {
                    $return = $return->where('users.email','=',Request::get('email'));
                }
        $return = $return->orderBy('users.id','desc')
                         ->limit(10)
                         ->get();
        return $return;
        }
    }

    static function getMyStudent($parent_id)
    {
        $return = self::select('users.*','class.name as class_id_name','parent.name as parent_name')
                ->join('users as parent','parent.id','=','users.parent_id','left')
                ->join('class','class.id','=','users.class_id','left')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0)
                ->where('users.parent_id','=',$parent_id)
                ->orderBy('users.id','desc')
                ->limit(50)
                ->get();
        return $return;
    }


    static public function getMyStudentIds($parent_id)
    {
            $return = self::select('users.id','class.name as class_id_name','parent.name as parent_name')
                    ->join('users as parent','parent.id','=','users.parent_id','left')
                    ->join('class','class.id','=','users.class_id','left')
                    ->where('users.user_type','=',3)
                    ->where('users.is_delete','=',0)
                    ->where('users.parent_id','=',$parent_id)
                    ->get();
        $myChildIds = array();
        foreach ($return as  $value) {
            $myChildIds[] = $value->id;
        }
            return $myChildIds;
    }



    

    static function getMyStudentCount($parent_id)
    {
        $return = self::select('users.id')
                ->join('users as parent','parent.id','=','users.parent_id','left')
                ->join('class','class.id','=','users.class_id','left')
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0)
                ->where('users.parent_id','=',$parent_id)
                ->count();
        return $return;
    }

    

    

    static function getEmailSingle($email)
    {
        return User::where('email','=',$email)->first();
    }
    static function getTokenSingle($remember_token)
    {
        return User::where('remember_token','=',$remember_token)->first();
    }

    public function getProfile()
    {
        if (!empty($this->profile_pic)&& file_exists('public/upload/profile_images/'.$this->profile_pic)) {
            return url('public/upload/profile_images/'.$this->profile_pic);
        }else{
            return url('public/upload/no_image.png');
        }
    }

    static function getStudentoOfTeacher($teacher_id){
        $return = self::select('users.*','class.name as class_id_name')
                ->join('class','class.id','=','users.class_id')
                ->join('assign_class_teacher','assign_class_teacher.class_id','=','class.id')
                ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                ->where('assign_class_teacher.status','=',0)
                ->where('assign_class_teacher.is_delete','=',0)
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0);

                
        $return = $return->orderBy('users.id','desc')
                         ->groupBy('users.id')
                         ->paginate(20);
        return $return;
    }

    static function getStudentoOfTeacherCount($teacher_id){
        $return = self::select('users.id')
                ->join('class','class.id','=','users.class_id')
                ->join('assign_class_teacher','assign_class_teacher.class_id','=','class.id')
                ->where('assign_class_teacher.teacher_id','=',$teacher_id)
                ->where('assign_class_teacher.status','=',0)
                ->where('assign_class_teacher.is_delete','=',0)
                ->where('users.user_type','=',3)
                ->where('users.is_delete','=',0);

                
        $return = $return->orderBy('users.id','desc')
                         ->count();
        return $return;
    }

    static function getAttendance($student_id,$class_id,$attendance_date)
    {
        return StudentAttendanceModel::checkAlreadyAttendance($student_id,$class_id,$attendance_date);
    }
    
}

<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\Upload;
use App\Http\Controllers\Controller;
use App\Models\Privileges;
use App\Models\User;
use App\Models\UserDocuments;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::
            where('role_id', 3)
            ->where('parent_id', Auth::user()->id)
            ->get();
        return view('dashboard.admin.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $privileges = Privileges::all();
        return view('dashboard.admin.create', compact('privileges'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname'              =>  'required',
            'mname'              =>  'string|nullable',
            'lname'              =>  'required',
            'email'              =>  'required|unique:users,email',
            'password'           =>  'required|confirmed',
            'phone'             =>  'required',
            'passport_no'       =>  'required',
            'profile_image'     =>  'required|mimes:svg,png,jpeg,jpg,gif',
            'id_image'          =>  'required|mimes:svg,png,jpeg,jpg,gif',
        ], [] , [
            'fname'              =>  'First Name',
            'mname'              =>  'Middle Name',
            'lname'              =>  'Last Name',
            'phone'             =>  'Phone',
            'passport_no'       =>  'Passport No',
            'profile_image'     =>  'Profile Image',
            'id_image'          =>  'ID Image',
        ]);

        try{

            //Upload Slide Image
            if ($uploadedFile = $request->file('profile_image'))
            {
                $profile_image = Upload::singleUpload($request,'profile_image','uploads/user/','profile_image','image|mimes:jpeg,jpg,png','App\Models\Image');
            }

            //Upload Slide Image
            if ($uploadedFile = $request->file('id_image'))
            {
                $id_image = Upload::singleUpload($request,'id_image','uploads/user/','id_image','image|mimes:jpeg,jpg,png','App\Models\Image');
            }

            $user = new User();
            $user->fname = $request->fname;
            $user->email = $request->email;
            $user->mname = $request->mname;
            $user->lname = $request->lname;
            $user->address = $request->address;
            $user->code_number  = 'USP' . date('dmy-his');
            $user->name = $request->fname . ' ' . $request->mname . ' ' . $request->lname;
            $user->phone = $request->phone;
            $user->role_id = 3;
            $user->image_id = $profile_image->id;
            $user->password = bcrypt($request->password);
            $user->parent_id = Auth::user()->id;
            $user->save();

            $documents = new UserDocuments();
            $documents->passport_no = $request->passport_no;
            $documents->user_id = $user->id;
            if ($uploadedFile = $request->file('id_image'))
            {
                $documents->identity_image_id = $id_image->id;
            }
            $documents->save();

            if (!empty(\request("privileges")))
            {
                foreach (\request("privileges") as $privilege):
                    DB::table('user_privilege')->insert([
                        'user_id' => $user->id,
                        'privilege_id' => $privilege,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                endforeach;
            }

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
        }


        return redirect(adminUrl('admin'))->with('create', 'تمت اضافة مشرف للتطبيق بنجاح');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $privileges = Privileges::all();
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        $user = User::find($id);
        return view('dashboard.admin.edit', compact('user', 'sp_doc', 'privileges'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'fname'              =>  'required',
            'mname'              =>  'string|nullable',
            'lname'              =>  'required',
            'password'           =>  'confirmed',
            'phone'             =>  'required',
            'passport_no'       =>  'required',
            'profile_image'     =>  'mimes:svg,png,jpeg,jpg,gif',
            'id_image'          =>  'mimes:svg,png,jpeg,jpg,gif',
        ], [] , [
            'fname'              =>  'First Name',
            'mname'              =>  'Middle Name',
            'lname'              =>  'Last Name',
            'phone'             =>  'Phone',
            'passport_no'       =>  'Passport No',
            'profile_image'     =>  'Profile Image',
            'id_image'          =>  'ID Image',
        ]);
        $user = User::findOrFail($id);

        //Upload Slide Image
        if ($uploadedFile = $request->file('profile_image'))
        {
            $profile_image = Upload::singleUpload($request,'profile_image','uploads/user/','profile_image','image|mimes:jpeg,jpg,png','App\Models\Image');
            $user->image_id = $profile_image->id;
        }

        //Upload Slide Image
        if ($uploadedFile = $request->file('id_image'))
        {
            $id_image = Upload::singleUpload($request,'id_image','uploads/user/','id_image','image|mimes:jpeg,jpg,png','App\Models\Image');
        }

        $user->fname = $request->fname;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->address = $request->address;
        $user->name = $request->fname . ' ' . $request->mname . ' ' . $request->lname;
        $user->phone = $request->phone;
        if (!empty($request->password))
        {
            $user->password = bcrypt($request->password);
        }
        $user->save();


        $documents = UserDocuments::with('identityImage')->where('user_id', $id)->firstOrFail();
        $documents->passport_no = $request->passport_no;
        if ($uploadedFile = $request->file('id_image'))
        {
            $documents->identity_image_id = $id_image->id;
        }
        $documents->save();


        $privileges = array();
        if (!empty(\request("privileges")))
        {
            foreach (\request("privileges") as $privilege):
                array_push($privileges, $privilege);
            endforeach;
            $user->privileges()->sync($privileges);
        }

        return redirect(adminUrl('admin'))->with('update', 'تمت تعديل مدير للتطبيق بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect(adminUrl('admin'))->with('update', 'تم حذف مدير للتطبيق بنجاح');
    }
}

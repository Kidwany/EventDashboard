<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\Upload;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Company;
use App\Models\CompanyCategories;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\EventGates;
use App\Models\File;
use App\Models\GateType;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use App\Models\Zone;
use App\Models\ZoneInstructions;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CompanyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $company = Company::with('event')->findOrFail($id);
        $event = Event::with('city')->findOrFail($company->event_id);
        $users = User::all()->where('company_id', $id)->where('role_id', 5);
        return view('dashboard.companyUser.index', compact('company', 'users', 'event'));
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id)
    {
        $company = Company::with('event')->findOrFail($id);
        $event = $company->event_id;
        $categories = CompanyCategories::all()->where('type', 'indiv')->where('is_active', 1);
        return view('dashboard.companyUser.create', compact('company', 'categories', 'event'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname'              =>  'required',
            'mname'              =>  'string|nullable',
            'lname'              =>  'required',
            'email'              =>  'required|unique:users,email',
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

            DB::beginTransaction();
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
            $user->company_id = $request->company_id;
            $user->category_id = $request->category_id;
            $user->address = $request->address;
            $user->code_number  = 'USP' . date('dmy-his');
            $user->name = $request->fname . ' ' . $request->mname . ' ' . $request->lname;
            $user->phone = $request->phone;
            $user->role_id = 5;
            $user->created_by = Auth::user()->id;
            $user->image_id = $profile_image->id;
            $user->save();

            $documents = new UserDocuments();
            $documents->passport_no = $request->passport_no;
            $documents->user_id = $user->id;
            if ($uploadedFile = $request->file('id_image'))
            {
                $documents->identity_image_id = $id_image->id;
            }
            $documents->save();

            User::where('id',$user->id)->update(['spqr'=>GenerateQr::generateQrCode(1,$user->id)]);

            DB::commit();

            return redirect(adminUrl('company-user/' . $user->company_id))->with('create', 'تمت اضافة المنظم بنجاح');

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
        }
    }

    /**
     * @param $event_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $user = User::with('company')->findOrFail($id);
        $categories = CompanyCategories::all()->where('type', 'indiv')->where('is_active', 1);
        $sp_doc = UserDocuments::with('identityImage')->where('user_id', $id)->first();
        return view('dashboard.companyUser.edit', compact('user', 'categories', 'sp_doc'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $user = User::with('company')->findOrFail($id);
        $request->validate([
            'fname'              =>  'required',
            'mname'              =>  'string|nullable',
            'lname'              =>  'required',
            'email'              =>  'required',
            'phone'             =>  'required',
            'passport_no'       =>  'required',
            'profile_image'     =>  'nullable|mimes:svg,png,jpeg,jpg,gif',
            'id_image'          =>  'nullable|mimes:svg,png,jpeg,jpg,gif',
        ], [] , [
            'fname'              =>  'First Name',
            'mname'              =>  'Middle Name',
            'lname'              =>  'Last Name',
            'phone'             =>  'Phone',
            'passport_no'       =>  'Passport No',
            'profile_image'     =>  'Profile Image',
            'id_image'          =>  'ID Image',
        ]);

        //Upload Slide Image
        if (!empty($request->profile_image) && $uploadedFile = $request->file('profile_image'))
        {
            $profile_image = Upload::singleUpload($request,'profile_image','uploads/user/','profile_image','image|mimes:jpeg,jpg,png','App\Models\Image');
            $user->image_id = $profile_image->id;
        }

        //Upload Slide Image
        if (!empty($request->id_image) && $uploadedFile = $request->file('id_image'))
        {
            $id_image = Upload::singleUpload($request,'id_image','uploads/user/','id_image','image|mimes:jpeg,jpg,png','App\Models\Image');
        }

        $user->fname = $request->fname;
        $user->email = $request->email;
        $user->mname = $request->mname;
        $user->lname = $request->lname;
        $user->category_id = $request->category_id;
        $user->address = $request->address;
        $user->code_number  = 'USP' . date('dmy-his');
        $user->name = $request->fname . ' ' . $request->mname . ' ' . $request->lname;
        $user->phone = $request->phone;
        $user->save();

        $documents = UserDocuments::with('identityImage')->where('user_id', $id)->firstOrFail();
        $documents->passport_no = $request->passport_no;
        if ($uploadedFile = $request->file('id_image'))
        {
            $documents->identity_image_id = $id_image->id;
        }
        $documents->save();

        return redirect('company-user/' . $user->company_id)->with('create', 'تم تعديل المنظم بنجاح');
    }


    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $company = Company::with('event')->findOrFail($id);
        $event = Event::with('city')->findOrFail($company->event_id);
        $users = User::all()->where('company_id', $id)->where('role_id', 5);
        return view('dashboard.company.users', compact('company', 'users', 'event'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id)
    {
        $zone = Zone::with('event')->findOrFail($id);
        DB::beginTransaction();
        try{

            $zone->is_active = 0;
            $zone->save();

            DB::commit();
            return redirect()->back()->with('create', 'تم مسح المنطقة بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }

}

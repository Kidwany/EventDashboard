<?php

namespace App\Http\Controllers;

use App\Classes\ErrorClass;
use App\Classes\Upload;
use App\Mail\VerifyUser;
use App\Models\City;
use App\Models\OrganizationDocs;
use App\Models\Phone;
use App\Models\User;
use App\Models\Verification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function authenticate(Request $request)
    {
        $request->validate([
            'fname'         =>  'required',
            'mname'         =>  'required',
            'lname'         =>  'required',
            'phone'         =>  'required|unique:users',
            'email'         =>  'required|email|unique:users',
            'password'      =>  'required|confirmed',
        ], [] , [
        ]);

        try
        {
            DB::beginTransaction();

            $user_phone = $request->phone;

            /**  create phone **/
            if($request->phone){
                $phone = new Phone();
                $phone->value=$request->phone;
                $phone->save();
                $request->phone=$phone->id;
            }

            $user = new User();
            $user->name         = $request->fname." ".$request->lname;
            $user->fname        = $request->fname;
            $user->mname        = $request->mname;
            $user->lname        = $request->lname;
            $user->code_number  = 'UORG' . date('dmy-his');
            $user->phone_id     = $request->phone;
            $user->phone        = $user_phone;
            $user->email        = $request->email;
            //$user->password   = Hash::make($request->password);
            $user->password     = bcrypt($request->password);
            $user->role_id      = 3;
            $user->lang         = "ar";
            $user->save();

            $verification = new Verification();
            $verification->code = rand(1000, 9999);
            $verification->user_id = $user->id;
            $verification->save();

            $organization_docs = new OrganizationDocs();
            $organization_docs->organization_id = $user->id;
            $organization_docs->save();

            Mail::to($user->email)->send(new VerifyUser($user, $verification->code));

            DB::commit();

            auth()->login($user);

            return redirect('complete-register')->with('warning', 'تم التسجيل بنجاح من فضلك قم بتأكيد الحساب عبر البريد الإلكتروني ... و استكمال البيانات المطلوبة ... شكرا لك');
        }
        catch (\Exception $exception){
            DB::rollBack();
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),0);
            return redirect()->back()->with('exception', 'حدث خطأ في عملية التسجيل')->withInput($request->input());
        }
    }

    public function completeRegister()
    {
        $cities = City::all()->where('country_id', 2);
        return view('dashboard.completeRegister', compact('cities'));
    }

    public function submitCompanyInfo(Request $request)
    {
        $request->validate([
            'name'                              =>  'required',
            'logo'                              =>  'required|mimes:jpeg,jpg,png,gif,svg',
            'city_id'                           =>  'required|int',
            'company_address'                           =>  'required',
            'bank_name'                         =>  'required',
            'ipan_no'                           =>  'required',
            'commercial_register'               =>  'required|mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg',
            'chamber_of_commerce_membership'    =>  'required|mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg',
            'social_insurance'                  =>  'required|mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg',
            'zakkah_certificate'                =>  'required|mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg',
            'saawada_certificate'               =>  'required|mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg',
        ], [] , [

            'commercial_register'               => 'السجل التجاري',
            'chamber_of_commerce_membership'    => 'عضوية الغرفة التجارية',
            'social_insurance'                  => 'التأمينات الإجتماعية',
            'zakkah_certificate'                => 'شهادة الزكاة',
            'saawada_certificate'               => 'شهادة السعودة',
        ]);

        try
        {

            DB::beginTransaction();

            /** Create Personal Image **/
            $personal_image = Upload::singleUpload($request,'logo','uploads/user/','personal image','image|mimes:jpeg,jpg,png','App\Models\Image');

            $user = User::findOrFail(auth()->user()->id);
            $user->image_id     = $personal_image->id;
            $user->city_id      = $request->city_id;
            $user->address      = $request->company_address;
            $user->is_docs_uploaded = 0;
            $user->save();

            /** User Bank Account Details **/
            $user->paymentInfo()->create([
                'user_id'   => $user->id,
                'bank'      => $request->bank_name,
                'ipan_no'   => $request->ipan_no
            ]);


            $organization_document = OrganizationDocs::where('organization_id', Auth::user()->id)->firstOrFail();

            /** Create CommercialRegister **/
            if (!empty($request->commercial_register))
            {
                $commercial_register = Upload::singleUpload($request,'commercial_register','uploads/organization/documents/','personal image','mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg','App\Models\File');
                $organization_document->commercial_register = $commercial_register->id;
            }
            if (!empty($request->chamber_of_commerce_membership))
            {
                /** Create CommercialRegister **/
                $chamber_of_commerce_membership = Upload::singleUpload($request,'chamber_of_commerce_membership','uploads/organization/documents/','personal image','mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg','App\Models\File');
                $organization_document->chamber_of_commerce_membership = $chamber_of_commerce_membership->id;
            }
            if (!empty($request->social_insurance))
            {
                /** Create social_insurance **/
                $social_insurance = Upload::singleUpload($request,'social_insurance','uploads/organization/documents/','personal image','mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg','App\Models\File');
                $organization_document->social_insurance = $social_insurance->id;
            }
            if (!empty($request->zakkah_certificate))
            {
                /** Create zakkah_certificate **/
                $zakkah_certificate = Upload::singleUpload($request,'zakkah_certificate','uploads/organization/documents/','personal image','mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg','App\Models\File');
                $organization_document->zakkah_certificate = $zakkah_certificate->id;
            }
            if (!empty($request->saawada_certificate))
            {
                /** Create zakkah_certificate **/
                $saawada_certificate = Upload::singleUpload($request,'saawada_certificate','uploads/organization/documents/','personal image','mimes:jpeg,jpg,png,doc,docx,pdf,gif,svg','App\Models\File');
                $organization_document->saawada_certificate = $saawada_certificate->id;
            }

            $organization_document->name = $request->name;
            $organization_document->save();

            DB::commit();

            return redirect('/')->with('create', 'تم ارسال المستندات بنجاح .. سيتم مراجعتها في خلال يومين عمل');

        }
        catch (\Exception $exception){
            DB::rollBack();
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),0);
            return redirect()->back()->with('exception', 'حدث خطأ في عملية التسجيل')->withInput($request->input());
        }


    }
}

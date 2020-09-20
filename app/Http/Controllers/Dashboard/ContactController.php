<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class ContactController extends Controller
{
    public function edit()
    {
        $contact = Contact::orderBy('created_at', 'desc')->first();
        return view('dashboard.contact.edit', compact('contact'));
    }


    public function update(Request $request)
    {
        $input = $request->all();
        $this->validate($request,[
            'email'         => 'bail|required|email|max:100',
            'phone'         => 'bail|required|min:8|max:20',
            'phone_alt'     => 'bail|max:20',
            'facebook'      => 'bail|url|nullable|max:191',
            'twitter'       => 'bail|url|nullable|max:191',
            'instagram'     => 'bail|url|nullable|max:191',
            'youtube'       => 'bail|url|nullable|max:191',
            'linkedin'      => 'bail|url|nullable|max:191',
            'pintrest'      => 'bail|url|nullable|max:191',
            'behance'       => 'bail|url|nullable|max:191',
            'google_plus'       => 'bail|url|nullable|max:191',
            'whatsapp'      => 'bail|required|max:191',
        ], [], [
            'email'         => 'Email',
            'phone'         => 'Phone',
            'address_en'    => 'Address in English',
            'address_ar'    => 'Address in Arabic',
            'facebook'      => 'Facebook',
            'twitter'       => 'Twitter',
            'instagram'     => 'Instagram',
            'youtube'       => 'Youtube',
            'linkedin'      => 'Linkedin',
            'pintrest'      => 'Pintrest',
            'behance'       => 'Behance',
            'whatsapp'      => 'Whatsapp',
            'google_plus'   => 'Google Plus',

        ]);

        $contact = Contact::orderBy('created_at', 'desc')->first();
        $contact->update($input);

        Session::flash('update', 'تم تعديل بيانات الاتصال بنجاح');
        return redirect(adminUrl('contact/edit'));
    }
}

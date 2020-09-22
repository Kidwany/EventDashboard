<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Classes\GenerateQr;
use App\Classes\UserSetting;
use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Event;
use App\Models\EventAttendRequest;
use App\Models\EventGates;
use App\Models\EventTools;
use App\Models\File;
use App\Models\GateType;
use App\Models\ServiceProviderExperience;
use App\Models\User;
use App\Models\UserDocuments;
use App\Models\UserGroup;
use App\Models\UserPaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class FilesController extends Controller
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|string
     */
    public function destroy($id, $group_id)
    {
        $file = File::findOrFail($id);
        DB::beginTransaction();
        try{
            DB::table('group_files')->where('user_group_id', $group_id)->where('file_id', $id)->delete();
            $file->delete();
            DB::commit();
            return redirect()->back()->with('create', 'تم مسح الملف بنجاح');

        }catch (\Exception $exception)
        {
            DB::rollBack();

            $error = new ErrorClass();
            return $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
        }
    }
}

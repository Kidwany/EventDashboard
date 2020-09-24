<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FinanceCategories;
use App\Models\FinanceExpenses;
use App\Models\FinanceSponsors;
use App\Models\FinanceTickets;
use App\Models\FinanceTotals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SponsorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        $sponsors = FinanceSponsors::all()->where('event_id', $event_id);
        return view('dashboard.sponsors.index', compact('event', 'sponsors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $v = Validator::make($request->all(), [
            'event_id'          => 'required',
            'category'       => 'required',
            'name'              => 'required',
            'expected'          => 'numeric|nullable',
            'real'              => 'numeric|nullable',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        DB::beginTransaction();

        $sponsor  = new FinanceSponsors();
        $sponsor->event_id = \request('event_id');
        $sponsor->category = \request('category');
        $sponsor->sponsor_name = \request('name');
        $sponsor->expected_sponsorship_value = \request('expected');
        $sponsor->real_sponsorship_value = \request('real');
        $sponsor->save();

        DB::table('finance_totals')
            ->where('event_id', $sponsor->event_id)
            ->where('category_id', 12)
            ->increment('total_expected', $sponsor->expected_sponsorship_value);

        DB::table('finance_totals')
            ->where('event_id', $sponsor->event_id)
            ->where('category_id', 12)
            ->increment('total_real_value', $sponsor->real_sponsorship_value);

        DB::commit();


        return redirect()->back()->with('create', 'تم اضافة الراعي بنجاح');
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
        $sponsor  = FinanceSponsors::findOrFail($id);
        $event = Event::findOrFail($sponsor->event_id);
        return view('dashboard.sponsors.edit', compact('event', 'sponsor'));
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
        $sponsor  = FinanceSponsors::findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'          => 'required',
            'category'       => 'required',
            'name'              => 'required',
            'expected'          => 'numeric|nullable',
            'real'              => 'numeric|nullable',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        try {


            DB::beginTransaction();

            DB::table('finance_totals')
                ->where('event_id', $sponsor->event_id)
                ->where('category_id', 12)
                ->decrement('total_expected', $sponsor->expected_sponsorship_value);

            DB::table('finance_totals')
                ->where('event_id', $sponsor->event_id)
                ->where('category_id', 12)
                ->decrement('total_real_value', $sponsor->real_sponsorship_value);

            $sponsor->category = \request('category');
            $sponsor->sponsor_name = \request('name');
            $sponsor->expected_sponsorship_value = \request('expected');
            $sponsor->real_sponsorship_value = \request('real');
            $sponsor->save();

            DB::table('finance_totals')
                ->where('event_id', $sponsor->event_id)
                ->where('category_id', 12)
                ->increment('total_expected', $sponsor->expected_sponsorship_value);

            DB::table('finance_totals')
                ->where('event_id', $sponsor->event_id)
                ->where('category_id', 12)
                ->increment('total_real_value', $sponsor->real_sponsorship_value);

            DB::commit();

            return redirect('sponsors/' . $sponsor->event_id)->with('create', 'تم تعديل الراعي بنجاح');

        }catch (\Exception $exception){
                $error = new ErrorClass();
                $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
                return redirect()->back()->with('exception', 'خطأ في حفظ البيانات')->withInput($request->input());
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $sponsor  = FinanceSponsors::findOrFail($id);
            DB::beginTransaction();

            DB::table('finance_totals')
                ->where('event_id', $sponsor->event_id)
                ->where('category_id', 12)
                ->decrement('total_expected', $sponsor->expected_sponsorship_value);

            DB::table('finance_totals')
                ->where('event_id', $sponsor->event_id)
                ->where('category_id', 12)
                ->decrement('total_real_value', $sponsor->real_sponsorship_value);

            $sponsor->delete();

            DB::commit();
            return redirect('sponsors/' . $sponsor->event_id)->with('create', 'تم مسح الراعي بنجاح');

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات');
        }
    }
}

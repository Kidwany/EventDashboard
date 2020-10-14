<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FinanceCategories;
use App\Models\FinanceExpenses;
use App\Models\FinanceTotals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ExpectedExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        $expenses = FinanceExpenses::with('category')->where('event_id', $event_id)->get();
        $categories = FinanceCategories::all()->where('type', 2);
        return view('dashboard.expectedExpenses.index', compact('event', 'expenses', 'categories'));
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
            'category_id'       => 'required',
            'item'              => 'required',
            'expected'          => 'numeric|nullable',
            'real'              => 'numeric|nullable',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        DB::beginTransaction();

        $expense  = new FinanceExpenses();
        $expense->event_id = \request('event_id');
        $expense->category_id = \request('category_id');
        $expense->item = \request('item');
        $expense->expected_value = \request('expected');
        $expense->real_value = \request('real');
        $expense->save();

        DB::table('finance_totals')
            ->where('event_id', $request->event_id)
            ->where('category_id', $expense->category_id)
            ->increment('total_expected', $expense->expected_value);

        DB::table('finance_totals')
            ->where('event_id', $request->event_id)
            ->where('category_id', $expense->category_id)
            ->increment('total_real_value', $expense->real_value);

        DB::commit();


        return redirect()->back()->with('create', 'تم اضافة التكلفة بنجاح');
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
        $expense  = FinanceExpenses::findOrFail($id);
        $event = Event::findOrFail($expense->event_id);
        $categories = FinanceCategories::all()->where('type', 2);
        return view('dashboard.expectedExpenses.edit', compact('event', 'expense', 'categories'));
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
        $expense  = FinanceExpenses::findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'          => 'required',
            'category_id'       => 'required',
            'item'              => 'required',
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
                ->where('event_id', $request->event_id)
                ->where('category_id', $expense->category_id)
                ->decrement('total_expected', $expense->expected_value);

            DB::table('finance_totals')
                ->where('event_id', $request->event_id)
                ->where('category_id', $expense->category_id)
                ->decrement('total_real_value', $expense->real_value);

            $expense->event_id = \request('event_id');
            $expense->category_id = \request('category_id');
            $expense->item = \request('item');
            $expense->expected_value = \request('expected');
            $expense->real_value = \request('real');
            $expense->save();

            DB::table('finance_totals')
                ->where('event_id', $request->event_id)
                ->where('category_id', $expense->category_id)
                ->increment('total_expected', $expense->expected_value);

            DB::table('finance_totals')
                ->where('event_id', $request->event_id)
                ->where('category_id', $expense->category_id)
                ->increment('total_real_value', $expense->real_value);

            DB::commit();

            return redirect('expected_expenses/' . $expense->event_id)->with('create', 'تم تعديل التكلفة بنجاح');

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
            $expense = FinanceExpenses::findOrFail($id);

            DB::table('finance_totals')
                ->where('event_id', $expense->event_id)
                ->where('category_id', $expense->category_id)
                ->decrement('total_expected', $expense->expected_value);

            DB::table('finance_totals')
                ->where('event_id', $expense->event_id)
                ->where('category_id', $expense->category_id)
                ->decrement('total_real_value', $expense->real_value);

            $expense->delete();

            return redirect('expected_expenses/' . $expense->event_id)->with('create', 'تم مسح التكلفة بنجاح');

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات');
        }
    }
}

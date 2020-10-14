<?php

namespace App\Http\Controllers\Dashboard;

use App\Classes\ErrorClass;
use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FinanceCategories;
use App\Models\FinanceExpenses;
use App\Models\FinanceTickets;
use App\Models\FinanceTotals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        $tickets = FinanceTickets::all()->where('event_id', $event_id);
        return view('dashboard.tickets.index', compact('event', 'tickets'));
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
            'price'              => 'required',
            'expected'          => 'numeric|nullable',
            'real'              => 'numeric|nullable',
            'sold'              => 'numeric|nullable',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        DB::beginTransaction();

        $ticket  = new FinanceTickets();
        $ticket->event_id = \request('event_id');
        $ticket->category = \request('category');
        $ticket->price = \request('price');
        $ticket->expected_number_of_tickets = \request('expected');
        $ticket->real_number_of_tickets = \request('real');
        $ticket->sold_tickets = \request('sold');
        $ticket->total_sales = \request('sold') * \request('price');
        $ticket->save();

        DB::table('finance_totals')
            ->where('event_id', $ticket->event_id)
            ->where('category_id', 11)
            ->increment('total_expected', $ticket->expected_number_of_tickets * $ticket->price);

        DB::table('finance_totals')
            ->where('event_id', $ticket->event_id)
            ->where('category_id', 11)
            ->increment('total_real_value', $ticket->total_sales);

        DB::commit();


        return redirect()->back()->with('create', 'تم اضافة التذكرة بنجاح');
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
        $ticket  = FinanceTickets::findOrFail($id);
        $event = Event::findOrFail($ticket->event_id);
        return view('dashboard.tickets.edit', compact('event', 'ticket', 'categories'));
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
        $ticket  = FinanceTickets::findOrFail($id);
        $v = Validator::make($request->all(), [
            'event_id'          => 'required',
            'category'       => 'required',
            'price'              => 'required',
            'expected'          => 'numeric|nullable',
            'real'              => 'numeric|nullable',
            'sold'              => 'numeric|nullable',
        ], [], []);

        if ($v->fails())
        {
            return redirect()->back()->with('errors', $v->errors())->withInput();
        }

        try {


            DB::beginTransaction();

            DB::table('finance_totals')
                ->where('event_id', $ticket->event_id)
                ->where('category_id', 11)
                ->decrement('total_expected', $ticket->expected_number_of_tickets * $ticket->price);

            DB::table('finance_totals')
                ->where('event_id', $ticket->event_id)
                ->where('category_id', 11)
                ->decrement('total_real_value', $ticket->total_sales);

            $ticket->category = \request('category');
            $ticket->price = \request('price');
            $ticket->expected_number_of_tickets = \request('expected');
            $ticket->real_number_of_tickets = \request('real');
            $ticket->sold_tickets = \request('sold');
            $ticket->total_sales = \request('sold') * \request('price');
            $ticket->save();

            DB::table('finance_totals')
                ->where('event_id', $ticket->event_id)
                ->where('category_id', 11)
                ->increment('total_expected', $ticket->expected_number_of_tickets * $ticket->price);

            DB::table('finance_totals')
                ->where('event_id', $ticket->event_id)
                ->where('category_id', 11)
                ->increment('total_real_value', $ticket->total_sales);

            DB::commit();

            return redirect('tickets/' . $ticket->event_id)->with('create', 'تم تعديل التذكرة بنجاح');

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
            DB::beginTransaction();
            $ticket  = FinanceTickets::findOrFail($id);

            DB::table('finance_totals')
                ->where('event_id', $ticket->event_id)
                ->where('category_id', 11)
                ->decrement('total_expected', $ticket->expected_number_of_tickets * $ticket->price);

            DB::table('finance_totals')
                ->where('event_id', $ticket->event_id)
                ->where('category_id', 11)
                ->decrement('total_real_value', $ticket->total_sales);

            $ticket->delete();

            DB::commit();
            return redirect('tickets/' . $ticket->event_id)->with('create', 'تم مسح التذكرة بنجاح');

        }
        catch (\Exception $exception){
            $error = new ErrorClass();
            $error->Error_Save(__CLASS__,__FUNCTION__,'=>'.$exception->getMessage().'. line=>'.$exception->getLine(),1);
            return redirect()->back()->with('exception', 'خطأ في حفظ البيانات');
        }
    }
}

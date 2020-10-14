<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\FinanceTotals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index($event_id)
    {
        $event = Event::findOrFail($event_id);
        $tickets_total = FinanceTotals::where('category_id', 11)->where('event_id', $event->id)->first();
        $sponsors_total = FinanceTotals::where('category_id', 12)->where('event_id', $event->id)->first();
        $spaces_total = FinanceTotals::where('category_id', 13)->where('event_id', $event->id)->first();
        $other_total = FinanceTotals::where('category_id', 14)->where('event_id', $event->id)->first();

        $total_expenses_value = DB::table('finance_totals')
            ->where('event_id', $event->id)
            ->where('type', 2)
            ->sum('total_real_value');

        $total_expenses_value > 0 ? $total_expenses_value = true : $total_expenses_value = 1;
        $expenses_totals = FinanceTotals::where('event_id', $event->id)
            ->where('type', 2)
            ->get();

        return view('dashboard.finance.index', compact(
            'event',
            'tickets_total',
            'sponsors_total',
            'spaces_total',
            'other_total',
            'total_expenses_value',
            'expenses_totals'
        ));
    }
}

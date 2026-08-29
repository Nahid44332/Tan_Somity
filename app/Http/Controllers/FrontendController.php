<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
public function index(Request $request)
{
    // আজকের তারিখের বদলে আপনার সমিতির স্থায়ী বা প্রথম শুরুর তারিখটি ডিফল্ট দিন
    $startDate = $request->input('start_date', '2026-08-19'); 
    $endDate = $request->input('end_date', \Carbon\Carbon::parse($startDate)->addDays(9)->toDateString());

    $members = Member::all();
    
    // নির্দিষ্ট সাইকেলের কালেকশন
    $collections = Collection::whereBetween('collection_date', [$startDate, $endDate])
                    ->get()
                    ->groupBy(function($item) {
                        return $item->member_id . '_' . $item->collection_date;
                    });

    // আজকের মোট জমা হিসাব করা (is_paid = true বা 1 ধরে)
    $today = Carbon::today()->toDateString();
    $todayCollection = Collection::where('collection_date', $today)
                        ->where('is_paid', 1)
                        ->sum('amount');
                        
    $totalCycleCollection = Collection::whereBetween('collection_date', [$startDate, $endDate])
                        ->where('is_paid', 1)
                        ->sum('amount');
    $lotteries = \App\Models\Lottery::with('member')->orderBy('draw_date', 'desc')->get();
    $previousWinnerIds = \App\Models\Lottery::pluck('member_id')->toArray();

    return view('frontend.index', compact('members', 'startDate', 'endDate', 'collections', 'todayCollection', 'totalCycleCollection', 'lotteries', 'previousWinnerIds'));
}
    public function store(Request $request)
    {
        $member = new Member();

        $member->name = $request->name;
        $member->phone = $request->phone;

        $member->save();
        return redirect()->back();
    }
}

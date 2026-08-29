<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LotteryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'member_id'   => 'required|exists:members,id',
            'draw_date'   => 'required|date',
            'amount'      => 'required|numeric',
            'draw_number' => 'nullable|integer',
        ]);

        \App\Models\Lottery::create([
            'member_id'   => $request->member_id,
            'draw_date'   => $request->draw_date,
            'amount'      => $request->amount,
            'draw_number' => $request->draw_number,
        ]);

        return redirect()->back()->with('success', 'লটারির বিজয়ী সফলভাবে এন্ট্রি করা হয়েছে!');
    }

    public function autoDraw(Request $request)
    {
        // ১. যারা ইতিমধ্যে লটারি জিতেছে তাদের বাদ দেওয়া
        $previousWinnerIds = \App\Models\Lottery::pluck('member_id')->toArray();
        $eligibleMembers = \App\Models\Member::whereNotIn('id', $previousWinnerIds)->get();

        if ($eligibleMembers->isEmpty()) {
            return redirect()->back()->with('error', 'লটারির জন্য আর কোনো যোগ্য সদস্য বাকি নেই!');
        }

        // ২. র‍্যান্ডম একজন বিজয়ী সিলেক্ট করা
        $winner = $eligibleMembers->random();
        $nextDrawNumber = \App\Models\Lottery::count() + 1;

        // ৩. বিজয়ী সদস্যকে সেশনে ধরে রাখা যাতে পপআপে দেখানো যায়
        return redirect()->back()->with([
            'pendingWinner' => $winner,
            'drawNumber' => $nextDrawNumber
        ]);
    }

    public function confirmWinner(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'draw_number' => 'required|integer',
        ]);

        \App\Models\Lottery::create([
            'member_id'   => $request->member_id,
            'draw_date'   => now()->toDateString(),
            'amount'      => 21000,
            'draw_number' => $request->draw_number,
        ]);

        return redirect()->back()->with('success', 'অভিনন্দন! লটারির বিজয়ী সফলভাবে কনফার্ম ও সেভ করা হয়েছে!');
    }
}

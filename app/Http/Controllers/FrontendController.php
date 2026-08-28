<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $members = Member::all();
    
    $startDate = Carbon::now()->subDays(5)->toDateString(); 
    $endDate = Carbon::now()->addDays(5)->toDateString();
        return view('frontend.index' ,compact('members'));
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

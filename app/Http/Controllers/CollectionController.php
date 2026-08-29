<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'member_id'       => 'required|exists:members,id',
            'collection_date' => 'required|date',
            'amount'          => 'required|numeric',
            'is_paid'         => 'required|boolean',
        ]);

        Collection::updateOrCreate(
            [
                'member_id'       => $request->member_id,
                'collection_date' => $request->collection_date,
            ],
            [
                'amount'  => $request->amount,
                'is_paid' => $request->is_paid,
            ]
        );

        return redirect()->back()->with('success', 'চাঁদার হিসাব সফলভাবে আপডেট করা হয়েছে!');
    }

}

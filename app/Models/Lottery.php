<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lottery extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'draw_date',
        'amount',
        'draw_number',
    ];

    // মেম্বার মডেলের সাথে রিলেশন (যাতে সহজেই বিজয়ীর নাম ও ডিটেইলস পাওয়া যায়)
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}

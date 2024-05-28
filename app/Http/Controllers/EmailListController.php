<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Http\Request;

class EmailListController extends Controller
{
    public function store(Request $request)
    {
        EmailList::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);
    }
}

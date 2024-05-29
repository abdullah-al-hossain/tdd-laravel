<?php

namespace App\Http\Controllers;

use App\Models\EmailList;
use Illuminate\Http\Request;

class EmailListController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        EmailList::create([
            'name' => $request->name,
            'user_id' => auth()->id(),
        ]);
    }

    public function index()
    {
        $lists = EmailList::where('user_id', auth()->id())->get();

        return response()->json([
            'data' => $lists
        ]);
    }

    public function update(Request $request, EmailList $list)
    {
        $list->update([
            'name' => $request->name,
        ]);

        return response([
            'data' => $list
        ]);
    }

    public function destroy(EmailList $list)
    {
        $list->delete();
        return response(null);
    }

    public function show($list)
    {
        $list = EmailList::where('user_id', auth()->id())->findOrFail($list);
        return response([
            'list'        => $list,
            'subscribers' => $list->subscribers,
        ]);
    }

}

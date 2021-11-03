<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\MailLog;

class LogController extends Controller
{
    public function logsIndex(Request $request)
    {
        $data = (object)[];
        $data->mail_log = MailLog::count();
        return view('admin.logs.index', compact('data'));
    }

    public function logsMail(Request $request)
    {
        $data = MailLog::latest()->paginate(25);
        return view('admin.logs.mail', compact('data'));
    }
}

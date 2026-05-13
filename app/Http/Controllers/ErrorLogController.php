<?php

namespace App\Http\Controllers;

use App\Models\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function store(Request $request)
    {
        ErrorLog::create($request->validate([
            'description' => ['required', 'string'],
        ]));

        return $this->respond($request, 'Запись журнала добавлена.');
    }

    public function destroy(ErrorLog $errorLog)
    {
        $errorLog->delete();

        return $this->respond(request(), 'Запись журнала удалена.');
    }
}

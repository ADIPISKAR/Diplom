<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function respond($request, string $message)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => $message]);
        }

        return redirect()->route('dashboard')->with('success', $message);
    }
}

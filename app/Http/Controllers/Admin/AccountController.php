<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Social;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::all();

        return view('admin.user.index', compact('accounts'));
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }
        
        $social = Social::where('user_id', $request->id)->delete();
        $user = User::where('id', $request->id)->delete();

        if ($social && $user) {
            return response()->json([
                'message' => trans('settings.success_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.error_message'),
        ]);
    }
}

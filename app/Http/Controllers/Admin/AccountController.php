<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Auth;
use App\Models\User;
use App\Models\Relationship;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::whereNotIn('id', [Auth::user()->id])->get();

        return view('admin.user.index', compact('accounts'));
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) {
            return response()->json([
                'message' => trans('settings.error_message'),
            ]);
        }
        
        $relationship = Relationship::where('target_id', $request->id)->delete();
        $user = User::where('id', $request->id)->delete();

        if ($relationship && $user) {
            return response()->json([
                'message' => trans('settings.success_message'),
            ]);
        }

        return response()->json([
            'message' => trans('settings.error_message'),
        ]);
    }
}

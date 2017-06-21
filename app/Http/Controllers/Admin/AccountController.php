<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
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

    public function edit($id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return redirect()->action('HomeController@error404');
        }

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
        } catch (ModelNotFoundException $ex) {
            return redirect()->action('HomeController@error404');
        }

        $profile = $request->only('role', 'name', 'location', 'note');
        $update = $user->update($profile);

        if (!$update) {
            return redirect()->back()
                ->with('status', 'danger')
                ->with('message', trans('settings.error_message'));
        }

        return redirect()->action('Admin\AccountController@index')
            ->with('status', 'success')
            ->with('message', trans('settings.success_message'));
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

<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use Auth;
use File;

class UserController extends Controller
{
    public function edit()
    {
        return view('user.profile.edit');
    }

    public function update(UserRequest $request)
    {
        $profileUpdate = $request->only('name', 'email', 'location', 'note');
        
        if (!empty($request->password)) {
            $profileUpdate['password'] = $request->password;
        }

        if (!empty($request->avatar)) {
            $profileUpdate['avatar'] = $this->uploadImage('avatar', Auth::user()->avatar);
        }

        if (!empty($request->cover)) {
            $profileUpdate['cover'] = $this->uploadImage('cover', Auth::user()->cover);
        }

        $update = Auth::user()->update($profileUpdate);

        if (!$update) {
            return redirect()->back();
        }

        return redirect()->action('HomeController@index');

    }

    protected function uploadImage($type, $oldImage = null)
    {
        $fileImage = Input::file($type);
        $destinationPath = public_path(config('settings.' . $type . '_path'));
        $fileName = config('settings.' . $type . '_path') . uniqid(time(), true) . '_' . $fileImage->getClientOriginalName();
        Input::file($type)->move($destinationPath, $fileName);
        $imageOldDestinationPath = $destinationPath . $oldImage;

        if (!empty($oldImage) && File::exists($imageOldDestinationPath)) {
            File::delete($imageOldDestinationPath);
        }

        return $fileName;
    }

    public function searchUser(Request $request)
    {
        if (!isset($request->search)) {
           $users = User::whereNotIn('id', [Auth::user()->id])
                ->with('relationships')
                ->paginate(config('settings.paginate_number'));
        } else {
           $users = User::where('name', 'like', '%' . $request->search . '%')
                ->with('relationships')
                ->orWhere('email', 'like', '%' . $request->search . '%')
                ->whereNotIn('id', [Auth::user()->id])
                ->paginate(config('settings.paginate_number'));
        }

        return view('user.profile.user', compact('users'));
    }

    public function followers()
    {
        $followers = Auth::user()->followers()->paginate(config('settings.paginate_number'));

        return view('user.relationship.follower', compact('followers'));
    }

    public function following()
    {
        $followings = Auth::user()->followings()->paginate(config('settings.paginate_number'));

        return view('user.relationship.following', compact('followings'));
    }

    public function addRelationship(Request $request)
    {   
        if (!$request->ajax()) {
            return response()->json([
                'status' => 'false',
            ]);
        }

        $user = Auth::user()->followings();

        if ($user->get()->contains('id', $request->id)) {
            $user->detach($request->id);
            $result = config('settings.action.remove');
        } else {
            $user->attach($request->id);
            $result = config('settings.action.add');
        }

        return response()->json([
            'status' => 'true',
            'result' => $result,
        ]);
    }      
}

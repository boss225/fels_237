<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
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

}

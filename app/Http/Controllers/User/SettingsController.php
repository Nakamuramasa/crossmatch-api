<?php

namespace App\Http\Controllers\User;

use App\Jobs\UploadImage;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use App\Rules\CheckSamePassword;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\Contracts\IUser;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class SettingsController extends Controller
{
    protected $users;

    public function __construct(IUser $users)
    {
        $this->users = $users;
    }

    public function updateProfile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'user_img' => ['required', 'file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:6000'],
            'sex' => ['required'],
            'about' => ['required', 'string', 'max:255'],
            'formatted_address' => ['required'],
            'location.latitude' => ['required', 'numeric', 'min:-90', 'max:90'],
            'location.longitude' => ['required', 'numeric', 'min:-180', 'max:180']
        ]);

        $image = $request->user_img;
        $image_path = $image->getPathName();
        $filename = time()."_".preg_replace('/\$+/', '_', strtolower($image->getClientOriginalName()));
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        $location = new Point($request->location['latitude'], $request->location['longitude']);

        $user = $this->users->update(auth()->id(), [
            'name' => $request->name,
            'user_img' => $filename,
            'sex' => $request->sex,
            'about' => $request->about,
            'location' => $location,
            'formatted_address' => $request->formatted_address,
            'upload_successful' => false,
            'disk' => config('site.upload_disk')
        ]);

        $this->dispatch(new UploadImage($user));

        return new UserResource($user);
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password' => ['required', 'string', 'min:8', new MatchOldPassword],
            'password' => ['required', 'string', 'min:8', 'confirmed', new CheckSamePassword]
        ]);

        $this->users->update(auth()->id(), [
            'password' => bcrypt($request->password)
        ]);

        return response()->json(['message' => 'Password updated'], 200);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Jobs\UploadImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected function registered(Request $request, User $user)
    {
        $this->dispatch(new UploadImage($user));
        return response()->json($user, 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:15', 'alpha_dash', 'unique:users,username'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'sex' => ['required'],
            'user_img' => ['file', 'image', 'mimes:jpeg,png,jpg,gif', 'max:6000'],
            'about' => ['string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $image = $data['user_img'];
        $image_path = $image->getPathName();
        $filename = time()."_".preg_replace('/\$+/', '_', strtolower($image->getClientOriginalName()));
        $tmp = $image->storeAs('uploads/original', $filename, 'tmp');

        return User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'about' => $data['about'] ?? "",
            'sex' => $data['sex'],
            'user_img' => $filename ?? "",
            'disk' => config('site.upload_disk'),
            'password' => Hash::make($data['password']),
        ]);
    }
}

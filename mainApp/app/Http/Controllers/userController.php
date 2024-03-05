<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

use Illuminate\Validation\Rule;
use function Laravel\Prompts\text;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class userController extends Controller
{
    public function storeAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|max:3000'
        ]);
        // $request->file('avatar')->store('public/avatars');
        // $imgData = Image::make($request->file('avatar'))->fit(120)->encode('jpg');
        // Storage::put('public/examplefolder/cool.jpg', $imgData);
        // create image manager with desired driver
        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($request->file('avatar'));

        // resize image proportionally to 300px width
        $image->scale(width: 120);

        // insert watermark
        // $image->place('images/watermark.png');

        // save modified image in new format 
        $image->toJpg()->save('storage\avatars\avatarcool.jpg');
    }

    public function showAvatarForm()
    {
        return view('avatar-form');
    }

    public function profile(User $user)
    {
        return view('profile-posts', ['username' => $user->username, 'post' => $user->posts()->latest()->get(), 'postCount' => $user->posts()->count()]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/')->with('success', 'You are now logged out.');
    }

    public function showCorrectHomepage()
    {
        if (auth()->check()) {
            return view('homepage-feed');
        } else {
            return view('homepage');
        }
    }

    public function login(Request $request)
    {
        $incomingFields = $request->validate([
            'loginusername' => 'required',
            'loginpassword' => 'required'
        ]);

        if (auth()->attempt(['username' => $incomingFields['loginusername'], 'password' => $incomingFields['loginpassword']])) {
            $request->session()->regenerate();
            return redirect('/')->with('success', 'You have successfully logged in.');
        } else {
            return redirect('/')->with('failure', 'Invalid login.');
        }
    }

    public function register(Request $request)
    {
        $incomingFields = $request->validate([
            'username' => ['required', 'min:3', 'max:20', Rule::unique('users', 'username')],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => ['required', 'min:8', 'confirmed']
        ]);

        $incomingFields['password'] = bcrypt($incomingFields['password']);

        $user = User::create($incomingFields);
        auth()->login($user);
        return redirect('/')->with('success', 'Thank you for creating an account.');
    }
}

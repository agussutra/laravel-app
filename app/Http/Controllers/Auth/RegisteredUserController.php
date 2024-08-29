<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\UserConfirmMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{

    public function index(): Response
    {
        return Inertia::render('Users/index',[
            'users' => User::all()
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required'],
        ]);

      $data =  User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Mail::to($data->email)->queue(new UserConfirmMail($data));

        Log::info('User created successfully', ['user' => $data]);
        return to_route('users.index');
    }

    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255',
            'password' => ['required'],
        ]);

        $data = tap(User::find($id))->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Log::info('User updated successfully', ['user' => $data, 'id' => $id]);
        return to_route('users.index');
    }

    public function destroy($id) {
        User::find($id)->delete();
        Log::info('User deleted successfully', ['id' => $id]);
        return to_route('users.index');
    }
}

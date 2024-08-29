<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Mail\UserConfirmMail;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function get_all()
    {
        $users = User::all();
        Log::info('User get successfully', ['users' => $users]);
        return ResponseFormatter::success(
            $users,
            'User found'
        );
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
                'password' => ['required'],
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            Mail::to($user->email)->queue(new UserConfirmMail($user));

            Log::info('User created successfully', ['user' => $user]);
            return ResponseFormatter::success($user, 'User created successfully.');
        } catch (Exception $e) {
            Log::info('User created error', ['message' => $e->getMessage()]);
            return ResponseFormatter::error($e->getMessage(),  500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|lowercase|email|max:255',
                'password' => ['required'],
            ]);

            $user = tap(User::find($id))->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            Log::info('User updated successfully', ['user' => $user]);
            return ResponseFormatter::success($user, 'User updated successfully.');
        } catch (Exception $e) {
            Log::info('User updated error', ['message' => $e->getMessage()]);
            return ResponseFormatter::error($e->getMessage(),  500);
        }
    }

    public function destroy($id)
    {
        User::find($id)->delete();
        Log::info('User deleted successfully', ['user' => $id]);
        return ResponseFormatter::success('User deleted successfully.');
    }

    public function insert_batch(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'users.*.email' => 'required|email|unique:users,email',
                'users.*.password' => 'required',
                'users.*.name' => 'required',
            ]);

           User::insert(collect($validatedData['users'])->map(function ($user) {
                return [
                    'email' => $user['email'],
                    'password' => Hash::make($user['password']),
                    'name' => $user['name'],
                ];
            })->toArray());


            Log::info('User created batch successfully', ['user' => null]);
            return ResponseFormatter::success(null, 'User batch created successfully.');

        } catch (Exception $e) {

            Log::info('User batch created error', ['message' => $e->getMessage()]);
            return ResponseFormatter::error($e->getMessage(),  500);
        }
    }
}

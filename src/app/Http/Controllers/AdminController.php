<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Mail\CreateUser;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->only(['name', 'email', 'join_date']);
        $users = User::search($params);

        return view('user.list', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(UserRequest $request)
    {
        // Generate a random password
        $password = $this->generateRandomPassword();

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($password),
            'is_password_changed' => false,
        ]);

        // Send the email with the generated password
        Mail::to($user->email)->send(new CreateUser($user, $password));

        return redirect()->route('user.list')->with('success', 'account created successfully.');
    }

    private function generateRandomPassword($length = 8)
    {
        // Arrays containing required character types
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $specialChars = '!@#$%^&*()_+-=[]{}|;:,.<>?';
        
        // Ensure the password contains at least one character from each type
        $password = [];
        $password[] = $uppercase[rand(0, strlen($uppercase) - 1)];
        $password[] = $lowercase[rand(0, strlen($lowercase) - 1)];
        $password[] = $numbers[rand(0, strlen($numbers) - 1)];
        $password[] = $specialChars[rand(0, strlen($specialChars) - 1)];

        // Generate additional random characters
        $allChars = $uppercase . $lowercase . $numbers . $specialChars;
        for ($i = 4; $i < $length; $i++) {
            $password[] = $allChars[rand(0, strlen($allChars) - 1)];
        }

        // Shuffle the characters and return the password
        return str_shuffle(implode('', $password));
    }

    public function detail($id)
    {
        $user = User::findOrFail($id);
        return view('user.detail', compact('user'));
    }

    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        return redirect()->route('user.list')->with('success', 'account updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.list')->with('success', 'account deleted successfully.');
    }
}

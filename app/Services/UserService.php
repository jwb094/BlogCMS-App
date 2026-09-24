<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

    public function store(array $newUserData): User
    {
        $newUserData['password_hash'] = Hash::make($newUserData['password']);
        $newUserData['role'] = 'author';
        $user = User::create($newUserData);

        return $user;
    }


    public function userAuth(array $loginDetails): bool
    {
        return Auth::attempt([
            'email' => $loginDetails['email'],
            'password' => $loginDetails['password']
        ]);
    }



    public function updateUserAccount(array $updatedUserData, int $updatedUserDataId): User
    {

        $updatedUser = User::findOrFail($updatedUserDataId);

        $updatedUserData['password'] = Hash::make($updatedUserData['password']);

        $updatedUser->update($updatedUserData);

        return $updatedUser->refresh();
    }


    public function resetUserPassword(array $updatedUserData): User
    {

        $user = User::where('email', $updatedUserData['email'])
            ->firstOrFail();

        $user->update([
            'password' => Hash::make($updatedUserData['password']),
        ]);

        return $user->refresh();
    }
}

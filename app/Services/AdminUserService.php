<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AdminUserService
{


    public function updateUserAccount(User $user, array $data): User
    {

        // $updatedUser = User::findOrFail($updatedUserDataId);


        if (isset($data['profile_photo'])) {

            if ($user->profile_photo) {
                Storage::disk('public')->delete(
                    $user->profile_photo
                );
            }

            $data['profile_photo'] = $data['profile_photo']
                ->store('profile-photos', 'public');
        }
        //dd($data);
        $user->update($data);

        return $user->refresh();
        // $updatedUser->update($updatedUserData);

        // return $updatedUser->refresh();
    }



    public function userPasswordUpdate(int $updatedUserDataId, array $updatedUserData): User
    {

        $user = User::where('id', $updatedUserDataId)
            ->firstOrFail();

        $user->update([
            'password' => Hash::make($updatedUserData['password']),
        ]);

        return $user->refresh();
    }
}

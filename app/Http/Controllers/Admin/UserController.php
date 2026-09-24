<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserUpdateFormRequest;
use App\Models\User;
use App\Services\AdminUserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected AdminUserService  $adminUserService;

    public function __construct(
        AdminUserService $adminUserService,
    ) {
        $this->adminUserService = $adminUserService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);

        return view('backend.profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateFormRequest $request)
    {

        //
        $this->adminUserService->updateUserAccount(
            $request->user(),
            $request->validated()
        );

        return back()
            ->with('status', "Success")
            ->with(
                'message',
                'Profile updated successfully.'
            );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function profile() {}

    public function password_change()
    {

        return view('backend.profile.change_password');
    }

    public function password_update(UserPasswordUpdateRequest $request)
    {

        $user = auth()->user();

        $this->adminUserService->userPasswordUpdate(
            (int) $user->id,
            $request->validated()
        );

        return  redirect(route('admin.dashboard'))
            ->with('message', "Password changed successfully");
    }

    public function logout(Request $request)
    {

        Session::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Auth::logout();

        return redirect(route('profile.login'));
    }
}

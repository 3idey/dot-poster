<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user)
    {
        $user->update(['is_banned' => true]);

        return back()->with('success', 'User banned.');
    }

    public function unban(User $user)
    {
        $user->update(['is_banned' => false]);

        return back()->with('success', 'User unbanned.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('username', 'like', '%' . $request->name . '%')
                    ->orWhere('email', 'like', '%' . $request->name . '%');
            });
        }
        if($request->filled('phone_number')) {
            $query->where('phone_number', 'like', '%' . $request->phone_number . '%');
        }
        $perPage = (int) $request->input('per_page', 10);
        $users = $query->where('role', 2)->orderBy('created_at', 'desc')->paginate($perPage)->appends($request->all());
        return view('admin.pages.user.list-user', compact('users'));
    }

    public function userDetail($userId)
    {
        $user = User::findOrFail($userId);
        return view('admin.pages.user.user-detail', compact('user'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function confirmDelete($id)
    {
        $user = User::find($id);
        return view('confirm-delete', compact('user'));
    }

    public function deleteConfirm(Request $request)
    {
        $selectedUsers = $request->input('selectedUsers');
        User::whereIn('id', $selectedUsers)->delete();

        return redirect('/table')->with('success', 'Data berhasil dihapus.');
    }

    public function info($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/table')->with('error', 'User tidak ditemukan');
        }

        return view('info', compact('user'));
    }

    public function edit($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/table')->with('error', 'User tidak ditemukan');
        }

        return view('edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect('/table')->with('error', 'User tidak ditemukan');
        }

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect('/table')->with('success', 'User berhasil diperbarui');
    }
}
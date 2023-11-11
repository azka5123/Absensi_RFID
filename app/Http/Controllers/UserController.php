<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller
{
    public function show_user()
    {
        $user = User::all();
        return view('user.user_show', compact('user'));
    }

    public function create_user()
    {
        return view('user.user_create');
    }

    public function store_user(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);
        $store = new User();
        $store->name = $request->nama;
        $store->email = $request->email;
        $store->password = Hash::make($request->password);
        $store->role = $request->role;
        $store->hp = $request->hp;
        $store->save();

        return redirect()->route('user')->with("success", "Data user berhasil ditambahkan");
    }

    public function edit_user($id)
    {
        $edit = User::where('id', $id)->first();
        return view("user.user_edit", compact('edit'));
    }

    public function update_user(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required',
            'role' => 'required'
        ]);
        $update = User::where('id', $id)->first();
        $update->name = $request->nama;
        $update->email = $request->email;
        if ($request->password == "") {
            $update->password;
        } else {
            $update->password = Hash::make($request->password);
        }
        $update->role = $request->role;
        $update->hp = $request->hp;
        $update->update();

        return redirect()->route('user')->with("success", "Data user berhasil diupdate");
    }

    public function delete_user($id)
    {
        User::find($id)->delete();
        return redirect()->route('user')->with("success", "Data user berhasil dihapus");
    }
}

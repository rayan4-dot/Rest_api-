<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id, Request $request)
    {
        $user = User::findOrFail($id);
        return response()->json($user->only('id', 'name', 'photo')); 
    }

    public function update($id, Request $request)
    {
        $user = User::findOrFail($id);
        if ($request->user()->id !== $user->id && !$request->user()->hasRole('admin')) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $data = $request->validate([
            'photo' => 'nullable|string', 
        ]);

        $user->update($data);
        return response()->json($user->only('id', 'name', 'photo')); 
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return response()->json(['message' => 'User deleted']);
    }
}
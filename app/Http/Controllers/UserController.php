<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::select($request->get('fields', '*'))
            ->when($request->has('search'), function ($query) use ($request) {
                $query->where('firstname', 'like', '%' . $request->search . '%')
                      ->orWhere('lastname', 'like', '%' . $request->search . '%')
                      ->orWhere('age', 'like', '%' . $request->search . '%')
                      ->orWhere('nickname', 'like', '%' . $request->search . '%');
            })
            ->orderBy($request->get('sort', 'id'))
            ->paginate($request->get('limit', 10));

        return response()->json($users);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer|min:0',
            'nickname' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'age' => 'required|integer|min:0',
            'nickname' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $user->update($request->all());

        return response()->json($user);
    }

    public function show(User $user)
    {
        return response()->json($user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(null, 204);
    }
}

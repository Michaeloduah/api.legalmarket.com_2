<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\LawyerProfile;
use App\Models\FirmProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'phone_number' => ['required', 'string', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
        ]);

        $validated["uuid"] = Str::uuid();

        // Create the user
        $user = User::create([
            'uuid' => $validated['uuid'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        Profile::create([
            "user_uuid" => $user->uuid,
        ]);

        if ($user->role === "lawyer") {
            LawyerProfile::create([
                "user_uuid" => $user->uuid,
            ]);
        };

        if ($user->role === "firm") {
            FirmProfile::create([
                "user_uuid" => $user->uuid,
            ]);
        };


        // Dispatch the registered event
        event(new Registered($user));

        // Return a JSON response with the user details and token
        if ($user->role === "firm") {
            return response()->json([
                'message' => 'User registered successfully',
                "user" => $user->load("profile", "firmProfile"),
            ], 201);
        } elseif ($user->role === "lawyer") {
            return response()->json([
                'message' => 'User registered successfully',
                "user" => $user->load("profile", "lawyerProfile"),
            ], 201);
        } else {
            return response()->json([
                'message' => 'User registered successfully',
                "user" => $user->load("profile"),
            ], 201);
        }
    }
}

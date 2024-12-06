<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Services\StorageService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected $storageService;

    public function __construct(StorageService $storageService)
    {
        $this->storageService = $storageService;
    }

    public function showProfile(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "User and Profile",
            "data" => [
                "user" => $user->load("profile")
            ]
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'job_title' => ['nullable', 'string', 'max:255'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'skills' => ['nullable', 'string', 'max:255'],
            'years_of_experience' => ['nullable', 'string', 'max:255'],
            'certifications' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'profile_picture' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg', 'max:10240'],
            'date_of_birth' => ['nullable', 'max:255'],
            'bio' => ['nullable', 'string', 'max:255'],
        ]);

        $fileData = $this->storageService->store($request->file('profile_picture'), Auth::user()->uuid);

        if (!$fileData) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Failed to upload file',
            ], 400);
        }
        $validated['profile_picture'] = $fileData;

        $user = Auth::user();
        $user->profile->update($validated);

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "Profile updated",
            "data" => [
                "user" => $user
            ]
        ]);
    }

    public function showLawyerProfile(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "User and Profile",
            "data" => [
                "user" => $user->load("lawyerProfile")
            ]
        ]);
    }

    public function updateLawyerProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'bar_certificate' => ['nullable', 'string', 'max:255'],
            'bar_association' => ['nullable', 'string', 'max:255'],
            'license_number' => ['nullable', 'string', 'max:255'],
            'license_issue_date' => ['nullable', 'string', 'max:255'],
            'license_expiry_date' => ['nullable', 'string', 'max:255'],
            'practice_areas' => ['nullable', 'mimes:jpeg,jpg,png,gif,svg', 'max:10240'],
            'years_of_experience' => ['nullable', 'max:255'],
            'law_firm' => ['nullable', 'string', 'max:255'],
            'availability' => ['nullable', 'string', 'max:255'],
            'professional_bio' => ['nullable', 'string', 'max:255'],
            'documents' => ['nullable', 'string', 'max:255'],
        ]);

        $fileData = $this->storageService->store($request->file('documents'), Auth::user()->uuid);

        if (!$fileData) {
            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => 'Failed to upload file',
            ], 400);
        }
        $validated['documents'] = $fileData;

        $user = Auth::user();
        $user->lawyerProfile->update($validated);

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "Profile updated",
            "data" => [
                "user" => $user
            ]
        ]);
    }

    public function showFirmProfile(): JsonResponse
    {
        $user = Auth::user();

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "User and Profile",
            "data" => [
                "user" => $user->load("firmProfile")
            ]
        ]);
    }

    public function updateFirmProfile(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'firm_name' => ['nullable', 'string', 'max:255'],
            'registration_number' => ['nullable', 'string', 'max:255'],
            'registration_date' => ['nullable', 'string', 'max:255'],
            'expiration_date' => ['nullable', 'string', 'max:255'],
            'contact_email' => ['nullable', 'string', 'max:255'],
            'contact_phone' => ['nullable', 'string', 'max:255'],
            'office_address' => ['nullable', 'string', 'max:255'],
            'practice_areas' => ['nullable', 'string', 'max:255'],
            'employees' => ['nullable', 'string', 'max:255'],
            'firm_size' => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'max:255'],
            'availability' => ['nullable', 'string', 'max:255'],
            'established_year' => ['nullable', 'string', 'max:255'],
            'bar_association' => ['nullable', 'string', 'max:255'],
            'professional_bio' => ['nullable', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        $user->firmProfile->update($validated);

        return response()->json([
            "status" => 200,
            "success" => true,
            "message" => "Professional Profile updated",
            "data" => [
                "user" => $user
            ]
        ]);
    }
}

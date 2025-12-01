<?php

namespace App\Http\Controllers\API\Profiles;

use App\Http\Controllers\RestfulController;
use App\Services\API\Profiles\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends RestfulController
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(Request $request)
    {
        return $this->profileService->show($request);
    }

    public function update(Request $request)
    {
        return $this->profileService->update($request);
    }

    public function updatePhoto(Request $request)
    {
        return $this->profileService->updatePhoto($request);
    }

    public function deletePhoto(Request $request)
    {
        return $this->profileService->deletePhoto($request);
    }

    public function updatePassword(Request $request)
    {
        return $this->profileService->updatePassword($request);
    }
}

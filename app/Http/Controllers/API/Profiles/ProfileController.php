<?php
/**
 * Company: CETAM
 * Project: ST
 * File: ProfileController.php
 * Created on: 28/11/2025
 * Created by: Alfonso Angel Garcia Hernandez
 * Approved by: Alfonso Angel Garcia Hernandez
 *
 * Changelog:
 * - ID: <ID> | Modified on: dd/mm/yyyy |
 * Modified by: <Developer name> |
 * Description: <Brief description of change> |
 */

namespace App\Http\Controllers\API\Profiles;

use App\Http\Controllers\Controller;
use App\Services\API\Profiles\ProfileService;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    /**

     * Create a new instance.

     *

     * @param ProfileService $profileService

     */

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    /**

     * Display the specified resource.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function show(Request $request)
    {
        return $this->profileService->show($request);
    }

    /**

     * Update the specified resource.

     *

     * @param Request $request

     *

     * @return \Illuminate\Http\JsonResponse

     */

    public function update(Request $request)
    {
        return $this->profileService->update($request);
    }

    /**

     * Update photo.

     *

     * @param Request $request

     *

     * @return void

     */

    public function updatePhoto(Request $request)
    {
        return $this->profileService->updatePhoto($request);
    }

    /**

     * Delete photo.

     *

     * @param Request $request

     *

     * @return void

     */

    public function deletePhoto(Request $request)
    {
        return $this->profileService->deletePhoto($request);
    }

    /**

     * Update password.

     *

     * @param Request $request

     *

     * @return void

     */

    public function updatePassword(Request $request)
    {
        return $this->profileService->updatePassword($request);
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\ProfileResource;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends ApiV1Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/profiles",
     *     tags={"Profiles"},
     *     summary="Get all profiles",
     *     description="Returns a list of all profiles",
     *     @OA\Response(response="200", description="profiles")
     * )
     */
    public function index()
    {
        $profiles = Profile::paginate(9);
        return ProfileResource::collection($profiles);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/profiles",
     *     tags={"Profiles"},
     *     summary="Create a new Profile",
     *     description="Creates a new Profile",
     *     @OA\Response(response="200", description="Profile created",description="OK"),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessible entity",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={"message": "Error", "errors": {"FIELD": "error1"}}, summary="An result object.")
     *          )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Schema(
     *          schema="Profiles"
     *          ),
     *          @OA\Property(
     *              property="bio",
     *              type="strig",
     *              example="DASDSADSAdsa"
     *          ),@OA\Property(
     *               property="address",
     *               type="string",
     *               example="232"
     *           ),@OA\Property(
     *               property="user_id",
     *               type="integer",
     *               format="int64",
     *               example="1"
     *           )
     *      )
     *         )
     *     ),
     *
     * )
     */
    public function store(Request $request)
    {
        $profile = Profile::create($request->validate(
            ['bio' => ['required', 'min:2'],
                'address' => ['required', 'min:2'],
                'user_id' => ['required', 'exists:App\Models\User,id'],
            ]
        ));
        return new ProfileResource($profile);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/profiles/{id}",
     *     tags={"Profiles"},
     *     summary="Show Profile",
     *     @OA\Parameter(
     *          in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200", description="Category find",description="OK"),
     *      @OA\Response(
     *           response=404,
     *           description="Cant find Profile",
     *           @OA\JsonContent(
     *               @OA\Examples(example="result", value={"message": "Error", "errors": {"FIELD": "error1"}}, summary="An result object.")
     *           )
     *       ),
     * )
     */
    public function show(string $id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            return new ProfileResource($profile);
        }
        return response()->json([
            'data' => null,
            'message' => 'not found'
        ], 404);
    }


    /**
     * @OA\Put(
     *     path="/api/v1/profiles",
     *     tags={"Profiles"},
     *     summary="update a new Profile",
     *     description="update a new Profile",
     *     @OA\Response(response="200", description="Profile updated",description="OK"),
     *     @OA\Response(
     *          response=422,
     *          description="Unprocessible entity",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={"message": "Error", "errors": {"FIELD": "error1"}}, summary="An result object.")
     *          )
     *      ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *              @OA\Schema(
     *           schema="Profiles"
     *           ),
     *           @OA\Property(
     *               property="bio",
     *               type="strig",
     *               example="DASDSADSAdsa"
     *           ),@OA\Property(
     *                property="address",
     *                type="string",
     *                example="232"
     *            ),@OA\Property(
     *                property="user_id",
     *                type="integer",
     *                format="int64",
     *                example="1"
     *            )
     *      )
     *         )
     *     ),
     *
     * )
     */
    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);
        $profile = Profile::update($request->validate(
            ['bio' => ['required', 'min:2'],
                'address' => ['required', 'min:2'],
                'user_id' => ['required', 'exists:App\Models\User,id'],
            ]
        ));
        return new ProfileResource($profile);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/profiles/{id}",
     *     tags={"Profiles"},
     *     summary="Delete Profile",
     *     @OA\Parameter(
     *          in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="404",description="Cant find category"),
     *     @OA\Response(response="204", description="Profile deleted",description="OK")
     *
     * )
     */
    public function destroy(string $id)
    {
        $profile = Profile::find($id);
        if ($profile) {
            $profile->delete();
            return response()->json('', 204);
        }
        return response()->json([
            'data' => null,
            'message' => 'not found'
        ]);
    }
}

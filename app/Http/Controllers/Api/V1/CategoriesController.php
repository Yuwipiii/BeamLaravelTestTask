<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoriesResource;
use App\Models\Category;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class CategoriesController extends ApiV1Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/categories",
     *     tags={"Categories"},
     *     summary="Get all categories",
     *     description="Returns a list of all categories",
     *     @OA\Response(response="200", description="List of categories")
     * )
     */
    public function index()
    {
        $categories = Category::paginate(9);
        return CategoriesResource::collection($categories);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/categories",
     *     tags={"Categories"},
     *     summary="Create a new category",
     *     description="Creates a new category",
     *     @OA\Response(response="200", description="Category created",description="OK"),
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
     *          schema="CategoryRequest",
     *          required="name"),
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Home"
     *          )
     *      )
     *         )
     *     ),
     *
     * )
     */
    public function store(Request $request): CategoriesResource
    {
        $category = Category::create($request->validate(['name'=>['required','min:2']]));
        return new CategoriesResource($category);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/categories/{id}",
     *     tags={"Categories"},
     *     summary="show category",
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
     *           description="Can find category",
     *           @OA\JsonContent(
     *               @OA\Examples(example="result", value={"message": "Error", "errors": {"FIELD": "error1"}}, summary="An result object.")
     *           )
     *       ),
     * )
     */
    public function show(string $id)
    {
        $category  = Category::find($id);
        if ($category) {
            return new CategoriesResource($category);
        }
        return response()->json([
            'data' => null,
            'message' => 'not found'
        ], 404);
    }



    /**
     * @OA\Put(
     *     path="/api/v1/categories",
     *     tags={"Categories"},
     *     summary="Edit category",
     *     description="Edit a category",
     *     @OA\Response(response="200", description="Category edited",description="OK"),
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
     *          schema="CategoryRequest",
     *          required="name"),
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Home"
     *          )
     *      )
     *         )
     *     ),
     *
     * )
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->validate(['name'=>['required','min:2']]));
        return new CategoriesResource($category);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/categories/{id}",
     *     tags={"Categories"},
     *     description="Delete Category",
     *     @OA\Parameter(
     *          in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(response="204", description="Category deleted",description="OK"),
     *     @OA\Response(response="404",description="Cant find category")
     * )
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);
        if ($category) {
            $category->delete();
            return response()->json('', 204);
        }
        return response()->json([
            'data' => null,
            'message' => 'not found'
        ]);
    }
}


<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProductController extends ApiV1Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Get all products ",
     *     description="Returns a list of all products",
     *     @OA\Response(response="200", description="products")
     * )
     */
    public function index()
    {
        $products = Product::paginate(9);
        return ProductResource::collection($products);
    }


    /**
     * @OA\Post(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="Create a new product",
     *     description="Creates a new product",
     *     @OA\Response(response="200", description="Product created",description="OK"),
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
     *          schema="products"
     *          ),
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Home"
     *          ),
     *          @OA\Property(
     *              property="body",
     *              type="strig",
     *              example="DASDSADSAdsa"
     *          ),@OA\Property(
     *               property="price",
     *               type="integer",
     *               example="232"
     *           ),@OA\Property(
     *               property="user_id",
     *               type="integer",
     *               format="int64",
     *               example="1"
     *           ),@OA\Property(
     *               property="category_id",
     *               type="integer",
     *              format="int64",
     *               example="3"
     *           )
     *      )
     *         )
     *     ),
     *
     * )
     */
    public function store(Request $request)
    {
        $product = Product::create($request->validate(
            ['name' => ['required', 'min:2'],
                'body' => ['required', 'min:2'],
                'price' => ['required', 'numeric', 'min:2'],
                'user_id' => ['required', 'exists:App\Models\User,id'],
                'category_id' => ['required', 'exists:App\Models\Category,id']
            ]
        ));
        return new ProductResource($product);
    }


    /**
     * @OA\Get(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Show product",
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
     *           description="Cant find product",
     *           @OA\JsonContent(
     *               @OA\Examples(example="result", value={"message": "Error", "errors": {"FIELD": "error1"}}, summary="An result object.")
     *           )
     *       ),
     * )
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            return new ProductResource($product);
        }
        return response()->json([
            'data' => null,
            'message' => 'not found'
        ], 404);
    }


    /**
     * @OA\Put(
     *     path="/api/v1/products",
     *     tags={"Products"},
     *     summary="update a new product",
     *     description="update a new product",
     *     @OA\Response(response="200", description="Product updated",description="OK"),
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
     *          schema="products"
     *          ),
     *          @OA\Property(
     *              property="name",
     *              type="string",
     *              example="Home"
     *          ),
     *          @OA\Property(
     *              property="body",
     *              type="strig",
     *              example="DASDSADSAdsa"
     *          ),@OA\Property(
     *               property="price",
     *               type="integer",
     *               example="232"
     *           ),@OA\Property(
     *               property="user_id",
     *               type="integer",
     *               format="int64",
     *               example="1"
     *           ),@OA\Property(
     *               property="category_id",
     *               type="integer",
     *              format="int64",
     *               example="3"
     *           )
     *      )
     *         )
     *     ),
     *
     * )
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);
        $product = Product::update($request->validate(
            ['name' => ['required', 'min:2'],
                'body' => ['required', 'min:2'],
                'price' => ['required', 'numeric', 'min:2'],
                'user_id' => ['required', 'exists:App\Models\User,id'],
                'category_id' => ['required', 'exists:App\Models\Category,id']
            ]
        ));
        return new ProductResource($product);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/products/{id}",
     *     tags={"Products"},
     *     summary="Delete product",
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
     *     @OA\Response(response="204", description="Product deleted",description="OK")
     *
     * )
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json('', 204);
        }
        return response()->json([
            'data' => null,
            'message' => 'not found'
        ]);
    }
}

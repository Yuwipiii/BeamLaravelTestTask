<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name'=>$this->resource->name,
            'body'=>$this->resource->body,
            'price'=>$this->resource->price,
            'category_id'=> new CategoriesResource($this->resource->category),
            'user_id'=> new UserResource($this->resource->user)
        ];
    }
}

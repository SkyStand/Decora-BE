<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\VariantResource;
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
            'id' => $this->id,
            'image' => $this->image,
            'name' => $this->name,
            'description' => $this->description,
            'type' => $this->type,
            'category' => $this->category,
            'style' => $this->style,
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}

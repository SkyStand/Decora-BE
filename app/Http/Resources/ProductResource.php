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
            'berat' => $this->berat,
            'panjang_product' => $this->panjang_product,
            'lebar_product' => $this->lebar_product,
            'tinggi_product' => $this->tinggi_product,
            'variants' => VariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}

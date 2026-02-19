<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ToolResource extends JsonResource
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
            'name' => $this->name,
            'slug' => $this->slug,
            'logo_url' => $this->logo_url,
            'short_description' => $this->short_description,
            'long_description' => $this->long_description,
            'website_url' => $this->website_url,
            'pricing_structured' => $this->pricing_structured,
            'pricing_text' => $this->pricing_text,
            'cta_type' => $this->cta_type,
            'cta_url' => $this->cta_url,
            'status' => $this->status,
            'is_claimed' => $this->is_claimed,
            'published_at' => $this->published_at,
            'vendor' => $this->whenLoaded('vendor'),
            'tier' => $this->whenLoaded('tier'),
            'categories' => $this->whenLoaded('categories'),
            'industries' => $this->whenLoaded('industries'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

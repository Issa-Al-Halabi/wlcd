<?php

namespace App\Http\Resources;

use App\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class FavCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $userId = auth()->id();

        return [
            'id' => $this->id,
            'title' => $this->title,
            'icon' => $this->icon,
            'slug' => $this->slug,
            'status' => $this->status,
            'featured' => $this->featured,
            'image' => $this->cat_image,
            'imagepath' => url('images/this/' . $this->cat_image),
            'position' => $this->position,
            'checked' => $this->whenLoaded('favoritedBy', function () use ($userId) {
                return $this->favoritedBy->contains('id', $userId) ? 1 : 0;
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

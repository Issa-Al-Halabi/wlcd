<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                'id' => $this->id,
                'user' => $this->user_id,
                'date' => $this->date,
                'image' => $this->image,
                'heading' => preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($this->heading))),
                'detail' => preg_replace("/\r\n|\r|\n/", '', strip_tags(html_entity_decode($this->detail))),
                'text' => $this->text,
                'approved' => $this->approved,
                'status' => $this->status,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
        ];
    }
}

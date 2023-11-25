<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCategoryResource extends JsonResource
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
            'id'    => $this->id,
            'name'  => $this->name,
            'status'  => $this->status ? 'Active': 'De-Active',
            'slug'  => $this->slug,
            'created_by'  => $this->created_by->first_name . ' ' . $this->created_by->last_name,
            'updated_by'  => isset( $this->updated_by ) ? $this->updated_by->first_name . ' ' . $this->updated_by->last_name : 'N / A',

        ];
    }
}

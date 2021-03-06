<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StaffResource extends JsonResource
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
            'id'                => (int) $this->id,
            'name'              => (string) ($this->name ?? ''),
            'phone'             => (string) ($this->phone ?? ''),
            'designationId'     => (int) ($this->designation_id ?? 0),
            'designationTitle'  => (string) ($this->designation->name ?? ''),
            'designation'       => new DesignationResource($this->whenLoaded('designation')),
            'allowDeletion'     => (boolean) (true),
            'imageUrl'          => (string) ($this->image->url ?? ''),
            'signatureUrl'      => (string) ($this->signature->url ?? ''),
        ];
    }
}

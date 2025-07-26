<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "team" => $this->name,
            "logo" => $this->logo,
            "coach" => $this->coach ? [
                    'name' => $this->coach->name,
                    "id" => $this->coach->id,
            ] : null ,
        ];
    }
}

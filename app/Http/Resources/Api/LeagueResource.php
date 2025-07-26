<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            "id" => $this->id,
            "name" => $this->name,
            "season" => $this->season,
            "start_date" => $this->start_date,
            "end_date" => $this->end_date,
//            "organizer" => $this->organizer->name,
            'organizer'  => $this->organizer ? [
                'name' => $this->organizer->name,
            ] : null,
        ];
    }
}

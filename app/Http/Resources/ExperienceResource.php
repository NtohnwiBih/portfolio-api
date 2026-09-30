<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'role_title' => $this->role_title,
            'company' => $this->company,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'is_current' => $this->is_current,
            'highlights' => $this->highlights->pluck('description'),
        ];
    }
}

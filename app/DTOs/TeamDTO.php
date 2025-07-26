<?php
namespace App\DTOs;

class TeamDTO {
    public function __construct(
        public int $id,
        public string $name,
        public string $logo,
        public int $coach_id,
    ){}
}

<?php

namespace App\DTOs;
use App\Enums\UserRole;

class UserDTO {
      public function __construct(
          public int $id,
          public string $name,
          public string $email,
          public UserRole $userRole
//          public string $password,
      ) {}
  }



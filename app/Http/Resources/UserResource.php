<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        if (auth()->check()) {
            $user = $request->user();
            return [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'token' => $user->createToken($user->email)->plainTextToken,
            ];
        } else {
            return [];
        }
    }
}

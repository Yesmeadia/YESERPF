<?php

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

trait HasApiTokens
{
    public function createToken(string $name, array $abilities = ['*'])
    {
        $token = Str::random(40);
        $hashedToken = hash('sha256', $token);

        $tokenId = DB::table('personal_access_tokens')->insertGetId([
            'tokenable_type' => static::class,
            'tokenable_id' => $this->id,
            'name' => $name,
            'token' => $hashedToken,
            'abilities' => json_encode($abilities),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return new class($token, $tokenId) {
            public string $plainTextToken;
            public int $id;

            public function __construct(string $token, int $id)
            {
                $this->plainTextToken = $token;
                $this->id = $id;
            }
        };
    }

    public function tokens()
    {
        return DB::table('personal_access_tokens')
            ->where('tokenable_type', static::class)
            ->where('tokenable_id', $this->id)
            ->get();
    }
}

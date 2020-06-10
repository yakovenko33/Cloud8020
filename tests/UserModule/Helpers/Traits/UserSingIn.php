<?php


namespace Tests\UserModule\Helpers\Traits;


use CarPark\UserModule\Infrastructure\Laravel\Database\Seeders\User;
use Illuminate\Support\Facades\Artisan;

trait UserSingIn
{
    /**
     * @param string $email
     * @param string $password
     * @return string
     */
    protected function singIn(string $email = "test_manager@gmail.com", string $password = "password_manager"): string
    {
        Artisan::call('db:seed', ["--class" => User::class]);

        $response = $this->json("POST", "/api/user/sing-in", [
            "email" => $email,
            "password" => $password
        ]);
        $response->assertStatus(200);

        $result = json_decode($response->content(), true);

        return $result["data"]["jwt_token"];
    }
}

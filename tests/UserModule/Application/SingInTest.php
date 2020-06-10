<?php


namespace Tests\UserModule\Application;


use CarPark\UserModule\Infrastructure\Laravel\Database\Seeders\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;
use Tests\UserModule\Helpers\DataClasses\SingInOrUp;
use Tests\UserModule\Helpers\DataProvider\ValidateSingUpOrIn;

class SingInTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        return ValidateSingUpOrIn::getData();
    }

    /**
     * @dataProvider dataProvider
     * @param SingInOrUp $data
     */
    public function testSingInErrors(SingInOrUp $data): void
    {
        $response = $this->json("POST", "/api/user/sing-in", $data->getRequest());

        $response
            ->assertStatus($data->getStatusCode())
            ->assertExactJson([
                "data" => [],
                "errors" => $data->getErrors(),
                "status" => $data->getStatus()
            ]);
    }

    public function testSingInErrorVerify(): void
    {
        Artisan::call('db:seed', ["--class" => User::class]);

        $response = $this->json("POST", "/api/user/sing-in", [
            "email" => "error@gmail.com",
            "password" => "password_error"
        ]);

        $response->assertStatus(403);
    }

    public function testSingInSuccess(): void
    {
        Artisan::call('db:seed', ["--class" => User::class]);

        $response = $this->json("POST", "/api/user/sing-in", [
            "email" => "test_manager@gmail.com",
            "password" => "password_manager"
        ]);

        $response->assertStatus(200);
    }
}

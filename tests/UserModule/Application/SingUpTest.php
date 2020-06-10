<?php


namespace Tests\UserModule\Application;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\UserModule\Helpers\DataClasses\SingInOrUp;
use Tests\UserModule\Helpers\DataProvider\ValidateSingUpOrIn;

class SingUpTest extends TestCase
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
    public function testSingUpErrors(SingInOrUp $data): void
    {
        $response = $this->json("POST", "/api/user/sing-up", $data->getRequest());

        $response
            ->assertStatus($data->getStatusCode())
            ->assertExactJson([
                "data" => [],
                "errors" => $data->getErrors(),
                "status" => $data->getStatus()
            ]);
    }

    public function testSingUpSuccess(): void
    {
        $response = $this->json("POST", "/api/user/sing-up", [
            "email" => "test@email.com",
            "password" => "123"
        ]);

        $response->assertStatus(201);
    }
}

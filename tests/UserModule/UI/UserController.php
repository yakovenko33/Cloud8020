<?php


namespace Tests\UserModule\UI;


use CarPark\UserModule\Infrastructure\Laravel\Database\Seeders\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\UserModule\Helpers\DataClasses\SingInOrUp;

class UserController extends TestCase
{
    use RefreshDatabase;

    public function testSingUpSuccess(): void
    {
        $response = $this->json("POST", "/api/user/sing-up", [
            "email" => "test@email.com",
            "password" => "123"
        ]);

        $response->assertStatus(201);
    }

    /**
     * @return array
     */
    public function dataProvider(): array
    {
        $request = [
            "email" => "test@email.com",
            "password" => "test"
        ];

        return  [
            [
                SingInOrUp::create(
                    array_merge($request, ["email" => '']),
                    [
                        "email" => [
                            'Поле email обязательно к заполнению.'
                        ]
                    ]
                )
            ],
            [
                SingInOrUp::create(
                    array_merge($request, ["email" => Str::random(51) . "@gmail.com"]),
                    [
                        "email" => [
                            'Длина email не должна превышать 50.'
                        ]
                    ]
                )
            ],
            [
                SingInOrUp::create(
                    array_merge($request, ["email" => Str::random(25)]),
                    [
                        "email" => [
                            'Email введён не коректно'
                        ]
                    ]
                )
            ],
            [
                SingInOrUp::create(
                    array_merge($request, ["email" => "test@email.com", "password" => ""]),
                    [
                        "password" => [
                            'Поле пароль обязательно к заполнению.'
                        ]
                    ]
                )
            ],
            [
                SingInOrUp::create(
                    array_merge($request, ["password" => Str::random(51)]),
                    [
                        "password" => [
                            'Длина пароля не должна превышать 50.'
                        ]
                    ]
                )
            ]
        ];
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

<?php


namespace Tests\UserModule\Helpers\DataProvider;


use Illuminate\Support\Str;
use Tests\UserModule\Helpers\DataClasses\SingInOrUp;

class ValidateSingUpOrIn
{
    /**
     * @return array
     */
    public static function getData(): array
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
}

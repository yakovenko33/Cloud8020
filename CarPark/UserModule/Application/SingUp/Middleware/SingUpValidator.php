<?php


namespace CarPark\UserModule\Application\SingUp\Middleware;


use CarPark\CommonModule\Bus\Validator\ValidatorRoot;

class SingUpValidator extends ValidatorRoot
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            "email" => 'required|string|max:50|email:rfc,dns',
            "password" => 'required|string|max:50'
        ];
    }

    /**
     * @return array
     */
    protected function getMessagesValidator(): array
    {
        return [
            'email.required' => 'Поле email обязательно к заполнению.',
            'email.max' => "Длина email не должна превышать :max.",
            'email.email' => "Email введён не коректно",
            'password.required' => 'Поле пароль обязательно к заполнению.',
            'password.max' => "Длина пароля не должна превышать :max.",
        ];
    }
}

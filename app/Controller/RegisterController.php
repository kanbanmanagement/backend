<?php

namespace Kanban\Controller;

use Slimvc\Controller;
use Kanban\Model\User;
use Slimvc\Validator;

/**
* RegisterController
*/
class RegisterController extends Controller
{
    public static $actions = [
        '/register'     => 'index',
        '/register/create' => 'createUser'
    ];

    private $errors = [];

    public function indexAction()
    {
        $registerFormData = [
          'name'     => 'Imię i nazwisko',
          'username' => 'Użytkownik',
          'password' => 'Hasło',
          'email'    => 'Adres e-mail',
          'email_confirmation'  => 'Potwierdzenie adresu e-mail'
        ];
        $result = array_map([$this, 'translate'], $registerFormData);
        $this->getApp()->render(200, [
            'response' => $result
        ]);
    }

    public function createUserAction()
    {
        if (!empty($this->getApp()->JSONBody) && $this->validateUserData($this->getApp()->JSONBody)) {
            $name = $this->getApp()->JSONBody['name'];
            $username = $this->getApp()->JSONBody['username'];
            $password = $this->getApp()->JSONBody['password'];
            $email = $this->getApp()->JSONBody['email'];
            $salt = mcrypt_create_iv(32);

            $user = new User($this->getConfig()['db']);
            $createUser = $user->set([
                'username' => $username,
                'password' => hash('sha256', $password . $salt),
                'salt' => $salt,
                'name' => $name,
                'email' => $email,
                'joined' => date('Y-m-d H:i:s'),
                'user_group' => 0
            ]);
            
            $this->getApp()->render(200, [
                'response' => $createUser
            ]);

        } else {
            $errors = array_map([$this, 'translate'], $this->errors);
            $this->getApp()->render(200, [
                'response' => $errors,
                'error' => true
            ]);
        }
    }

    private function validateUserData($data)
    {
        $properValues = array(
            'name' => array(
                'name' => 'Name',
                'min_length' => 2,
                'max_length' => 50,
                'regex' => '/^[a-zA-Z ]+$/'
            ),
            'username' => array(
                'name' => 'Username',
                'min_length' => 2,
                'max_length' => 20,
                'unique' => 'users',
                'regex' => '/^[\w\-]+$/'
            ),
            'password' => array(
                'name' => 'Password',
                'min_length' => 6
            ),
            'email' => array(
                'name' => 'E-mail',
                'valid_email' => true,
                'unique' => 'users'
            ),
            'email_confirmation' => array(
                'name' => 'E-mail confirmation',
                'matches' => 'email'
            )
        );

        $user = new User($this->getConfig()['db']);

        $validator = new Validator($user, $data, $properValues);
        $validator->validate();
        $this->errors = $validator->errors();

        return $validator->isValid();
    }
}

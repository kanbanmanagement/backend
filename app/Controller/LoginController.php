<?php

namespace Kanban\Controller;

use Slimvc\Controller;
use Kanban\Model\User;
/**
* LoginController
*/
class LoginController extends Controller
{
    public static $actions = [
        '/login'        => 'index',
        '/login/verify' => 'verify',
        '/login/forgot' => 'forgotPassword'
    ];

    public function indexAction()
    {
        $loginFormData = [
          'user'     => 'Użytkownik',
          'password' => 'Hasło',
          'forgot'   => 'Przypomnij hasło',
          'submit'   => 'Zaloguj'
        ];

        $this->getApp()->render(200, [
            'response' => array_map([$this,'translate'], $loginFormData)
        ]);
    }

    public function verifyAction()
    {
        if ($this->getApp()->request->isPost()) {
            $user = new User($this->getConfig()['db']);
            $login =  $this->getApp()->JSONBody['name'];
            $password = $this->getApp()->JSONBody['pass'];

            $result = false;
            $payload = $user->get('password', ['username' => $login]);
            if (!empty($payload)) {
                list($row) = $payload;
                if ($password === $row['password']) {
                    $result = true;
                }
            }

            $this->getApp()->render(200, [
                'response' => $result
            ]);
        }

    }

    public function forgotPasswordAction()
    {
        $domain = "sandboxff5d83dc98294431845e49a88376d4aa.mailgun.org";
        # $emailAdress = "kanbanmanagement@gmail.com";
        if ($this->getApp()->request->isPost()) {
            $emailAdress = $this->getApp()->JSONBody['email'];
            if (filter_var($emailAdress, FILTER_VALIDATE_EMAIL)) {
                $this->getConfig()['mg']->sendMessage("$domain", [
                    'from'    => 'no-replay <no-replay@kanbanmanagement.com>',
                    'to'      => $emailAdress,
                    'subject' => $this->translate('Przypomnij hasło'),
                    'html'    => file_get_contents(APP_PATH.'/../app/Template/forgot.html', FILE_USE_INCLUDE_PATH)
                                ]);
                $this->getApp()->render(200, [
                 'response' => $this->translate('Wysłaliśmy Ci e-mail z instrukcją jak ustawić nowe hasło')
                ]);
            } else {
                $this->getApp()->render(200, [
                    'response' => $this->translate('Podane dane są niepoprawne')
                ]);
            }
        }
    }
}

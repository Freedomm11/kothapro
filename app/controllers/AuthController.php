<? namespace App\controllers;

use App\models\QueryBuilder;
use App\models\Template;
use Delight\Auth\Auth;
use SimpleMail;
use Tamtamchik\SimpleFlash\Flash;
use PDO;


class AuthController {

    public $qb;
    public $pdo;
    public $tpl;
    public $auth;
    public $flash;


    public function __construct(PDO $pdo, QueryBuilder $qb, Template $template, Auth $auth, Flash $flash)
    {
        $this->qb = $qb;
        $this->pdo = $pdo;
        $this->tpl = $template;
        $this->auth = $auth;
        $this->flash = $flash;
    }



    public function registration()
    {
        if (isset($_POST['btn-register'])){

            try {
                $userId = $this->auth->register($_POST['email'], $_POST['password'], $_POST['username'], function ($selector, $token) {

                    $url = 'http://kothapro/verification?selector=' . \urlencode($selector) . '&token=' . \urlencode($token);

                    SimpleMail::make()
                        ->setTo($_POST['email'], 'dear friend')
                        ->setSubject('Subscription')
                        ->setMessage("<a href='$url '>verification link</a>")
                        ->setHtml()
                        ->send();
                });

                try {
                    $this->auth->admin()->addRoleForUserById($userId, \Delight\Auth\Role::AUTHOR);
                }

                catch (\Delight\Auth\UnknownIdException $e) {
                    echo $this->tpl->getPage('public/registration',  [
                        'message' => $this->flash->warning('Unknown user ID')
                    ]); }
            }

            catch (\Delight\Auth\InvalidEmailExceptionUsernameException $e) {
                echo $this->tpl->getPage('public/registration',  [
                    'message' => $this->flash->warning('USER address')
                ]); }
            catch (\Delight\Auth\InvalidEmailException $e) {
                echo $this->tpl->getPage('public/registration',  [
                    'message' => $this->flash->warning('Invalid email address')
                ]); }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                echo $this->tpl->getPage('public/registration', [
                    'message' => $this->flash->warning('Invalid password')
                ]); }
            catch (\Delight\Auth\UserAlreadyExistsException $e) {
                echo $this->tpl->getPage('public/registration', [
                    'message' => $this->flash->warning('User already exists')
                ]); }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                echo $this->tpl->getPage('public/registration', [
                    'message' => $this->flash->warning('Too many requests')
                ]); }
        }

        if (isset($_POST['btn-register'])){
            echo $this->tpl->getPage('public/registration', [
                'message' => $this->flash->success('A confirmation email has been sent to your email address')]);} else {
            echo $this->tpl->getPage('public/registration', [null]);
        }
    }



    public function verification()
    {
        try {
            $this->auth->confirmEmail($_GET['selector'], $_GET['token']);
            header('Location: /login');
        }
        catch (\Delight\Auth\InvalidSelectorTokenPairException $e) {
            die('Invalid token');
        }
        catch (\Delight\Auth\TokenExpiredException $e) {
            die('Token expired');
        }
        catch (\Delight\Auth\UserAlreadyExistsException $e) {
            die('Email address already exists');
        }
        catch (\Delight\Auth\TooManyRequestsException $e) {
            die('Too many requests');
        }

        echo $this->tpl->getPage('public/registration', [null]);
    }



    public function login()
    {
        if (isset($_POST['btn-login'])){

            try {
                if ($_POST['remember'] == 1) {
                    // keep logged in for one year
                    $rememberDuration = (int) (60 * 60 * 24 * 365.25);
                }
                else {
                    // do not keep logged in after session ends
                    $rememberDuration = null;
                }

                $this->auth->login($_POST['email'], $_POST['password'], $rememberDuration);
                header('Location: /');
            }

            catch (\Delight\Auth\InvalidEmailException $e) {
                echo $this->tpl->getPage('public/login', [
                    'message' => $this->flash->warning('Wrong email address')]);
            }
            catch (\Delight\Auth\InvalidPasswordException $e) {
                echo $this->tpl->getPage('public/login', [
                    'message' => $this->flash->warning('Wrong password')]);
            }
            catch (\Delight\Auth\EmailNotVerifiedException $e) {
                echo $this->tpl->getPage('public/login', [
                    'message' => $this->flash->warning('Email not verified')]);
            }
            catch (\Delight\Auth\TooManyRequestsException $e) {
                echo $this->tpl->getPage('public/login', [
                    'message' => $this->flash->warning('Too many requests')]);
            }
        }

        echo $this->tpl->getPage('public/login', [null]);
    }



    public function logout()
    {
        $this->auth->logOut();
        $this->auth->destroySession();

        try {
            $this->auth->logOutEverywhere();
        }
        catch (\Delight\Auth\NotLoggedInException $e) {
            header('Location: /');
        }
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: peter
 * Date: 23/03/19
 * Time: 14:10
 */

namespace Usuarios\Model;

use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter as AuthAdapter;
use Zend\Authentication\Result;
use Zend\View\Exception\RuntimeException;


class Login
{
    const NOT_IDENTITY = 'notIdentity';
    const INVALID_CREDENTIAL = 'invalidCredential';
    const INVALID_USER = 'invalidUser';
    const INVALID_LOGIN = 'invalidLogin';
    protected $messages = [
        self::NOT_IDENTITY => "Not existent identity. A record with the supplied identity could not be found.",
        self::INVALID_CREDENTIAL => "Invalid credential. Supplied credential is invalid.",
        self::INVALID_USER => "Invalid User. Supplied credential is invalid",
        self::INVALID_LOGIN => "Invalid Login. Fields are empty"];

    private $auth,
        $authAdapter;

    /**
     * Login constructor.
     * @param $authAdapter
     */
    public function __construct($dbAdapter)
    {
        $this->authAdapter = new AuthAdapter($dbAdapter, 'usuarios', 'email', 'password');
        $this->auth = new AuthenticationService();
    }

    public function login($identifier, $password)
    {
        if (!empty($identifier) && !empty($password)) {
            $this->authAdapter->setIdentity($identifier);
            $this->authAdapter->setCredential($password);

            $result = $this->auth->authenticate($this->authAdapter);
            switch ($result->getCode()) {
                case Result::FAILURE_IDENTITY_NOT_FOUND:
                    throw new RuntimeException($this->messages[self::NOT_IDENTITY]);
                    break;
                case Result::FAILURE_CREDENTIAL_INVALID:
                    throw new RuntimeException($this->messages[self::INVALID_CREDENTIAL]);
                    break;
                case Result::SUCCESS:
                    if ($result->isValid()) {
                        $data = $this->authAdapter->getResultRowObject();
                        $this->auth->getStorage()->write($data);
                    } else {
                        throw new RuntimeException($this->messages[self::INVALID_USER]);
                    }
                    break;
                default:
                    throw new RuntimeException($this->messages[self::INVALID_LOGIN]);
                    break;
            }
        } else {
            throw new RuntimeException($this->messages[self::INVALID_LOGIN]);
        }

        return $this;
    }

    public function logout()
    {
        $this->auth->clearIdentity();
        return $this;
    }

    public function getIdentity()
    {
        if ($this->auth->hasIdentity()) {
            return $this->auth->getIdentity();
        }
        return null;
    }

    public function isLoggedIn()
    {
        return $this->auth->hasIdentity();
    }

    public function setMessage($messageString, $messageKey = null)
    {
        if ($messageKey === null) {
            $keys = array_keys($this->messages);
            $messageKey = current($keys);
        }
        if (!isset($this->messages[$messageKey])) {
            throw new \Exception("No message exists for key '$messageKey'");
        }
        $this->messages[$messageKey] = $messageString;
        return $this;
    }

    public function setMessages(array $messages)
    {
        foreach ($messages as $key => $message) {
            $this->setMessage($message, $key);
        }
        return $this;
    }

}
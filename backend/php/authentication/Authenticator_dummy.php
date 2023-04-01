<?php

namespace backend\php\authentication;


/**
 * @deprecated Dummy Class
 * I'm making this class with the intention of it being a singleton instance.
 * But I am not sure if this is the standard for user authentication
 */
class Authenticator_dummy implements AuthenticatorInterface
{
    private static ?Authenticator_dummy $instance = null;

    private function __construct()
    {
        // connect to user authenticator service
    }

    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * @deprecated This is a dummy, so it will only return true
     * @param string $type
     * @return bool
     */
    public function userIs(string $type): bool
    {
        // TODO: Implement userIs() method.
        return true;
    }
}
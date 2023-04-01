<?php

namespace backend\php\authentication;

/**
 * Maybe users can have different attributes?
 * E.g. An admin will have the attributes of an editor, moderator, etc.
 * So using the userIs('editor') function will return true for an 'admin'
 * But using userIs('admin') for an 'editor' won't necessarily return true
 */
interface AuthenticatorInterface
{
    /**
     * Returns whether the user is a certain type
     */
    public function userIs(string $type):bool;
}
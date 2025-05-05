<?php

namespace App\Services;

class AuthService 
{
    /**
     * Criptografa uma senha usando Bcrypt
     * 
     * @param string $password Senha em texto puro
     * @return string Senha criptografada
     */
    public static function encryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * Verifica se o usuário está autenticado (sessão iniciada com user_id)
     * 
     * @return bool
     */
    public static function isAuthenticated(): bool
    {
        return session()->has('user_id');
    }
}

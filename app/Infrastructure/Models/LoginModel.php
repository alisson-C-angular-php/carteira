<?php

namespace App\Infrastructure\Models;

use CodeIgniter\Model;
class LoginModel extends Model
{
    protected $table = "tb_usuario";

    protected $fillable = ['email', 'senha'];
}
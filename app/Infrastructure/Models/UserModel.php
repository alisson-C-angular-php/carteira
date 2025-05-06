<?php

namespace App\Infrastructure\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "tb_usuario";
    protected $primaryKey = "id";

    protected $allowedFields = ['nome', 'email', 'senha', 'saldo'];
}

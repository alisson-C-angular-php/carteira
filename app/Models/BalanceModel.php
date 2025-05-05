<?php

namespace App\Models;

use CodeIgniter\Model;

class BalanceModel extends Model
{
    protected $table = 'tb_saldo_usuario';
    protected $primaryKey = 'codigo';

    protected $allowedFields = ['usuario_codigo', 'saldo', 'data_atualizacao'];


   
}

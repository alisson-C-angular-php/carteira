<?php

// app/Models/TransactionModel.php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table = 'tb_transacoes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_from_id',
        'user_to_id',
        'valor',
        'tipo',
        'reversivel',
        'criado_em'
    ];
    protected $useTimestamps = true;
    protected $createdField  = 'criado_em';
}

<?php

namespace App\Infrastructure\Repository;


use App\Infrastructure\Models\TransactionModel;

class TransactionRepository
{
    protected TransactionModel $transactionModel;

    public function __construct()
    {
        $this->transactionModel = new TransactionModel();
    }

    public function getById(int $id): ?array
    {
        return $this->transactionModel->find($id);
    }
    
   


    public function updateReverteOperacoes(int $transacaoId)
    {
        $db = \Config\Database::connect();

        try {
            $sql = "CALL sp_reverter_transacao(?)";
            $db->query($sql, [$transacaoId]);

            return true;
        } catch (\Exception $e) {
            log_message('error', 'Erro ao reverter operação: ' . $e->getMessage());
            return false;
        }
    }


    public function getHistoricoPorTransacoes(int $usuarioId)
    {
        $db = \Config\Database::connect();

        $res = $db->query("CALL sp_select_historico_transacoes(?)", [$usuarioId])->getResultArray();
        
        if ($res) {
            return $res;
        } else {
            return null;
        }
    }


    public function getSaldoAtualUsuario($usuarioId)
    {
        $db = \Config\Database::connect();

        $res = $db->query("CALL sp_select_saldo(?)", [$usuarioId])->getResultArray();
        if ($res) {
            return $res[0]["saldo"];
        } else {
            return null;
        }
    }



    public function inserirTransacao($usuarioFromId, $usuarioToId, $valor, $tipo, $reversivel)
    {
        $db = \Config\Database::connect();

        $reversivel = ($reversivel) ? 1 : 0;


        $sql = "CALL sp_insert_transacao(?, ?, ?, ?, ?)";

        try {
            $query = $db->query($sql, [
                $usuarioFromId,
                $usuarioToId,
                $valor,
                $tipo,
                $reversivel
            ]);

            if ($query) {
                return true;
            } else {
                throw new \Exception('Erro desconhecido ao realizar a transação.');
            }
        } catch (\Exception $e) {

            return $e->getMessage();
        }
    }







}

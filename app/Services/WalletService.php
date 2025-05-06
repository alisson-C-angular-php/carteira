<?php

namespace App\Services;

use App\Repository\TransactionRepository;
use App\Models\UserModel;
use App\Models\TransactionModel;

class WalletService
{
    protected $transactionRepository;
    protected $userModel;

    protected $transactionModel;

    public function __construct(
        TransactionRepository $transactionRepository,
        UserModel $userModel,
        TransactionModel $transactionModel
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->userModel = $userModel;
        $this->transactionModel = $transactionModel;
    }
    

    public function deposit(int $userId, float $valor)
    {
        $user = $this->userModel->find($userId);
        if (!$user) {
            throw new \Exception("Usuário não encontrado.");
        }

        $user['saldo'] += $valor;
        $this->userModel->update($userId, ['saldo' => $user['saldo']]);

        $res = $this->transactionRepository->inserirTransacao(
            $userId,          
            $userId,          
            $valor,           
            'deposito',      
            true            
        );

        if ($res === true) {
            return ;
        } else {
            return redirect()->back()->with('error', $res);
        }
    
    }

    public function transfer(int $fromUserId, int $toUserId, float $valor)
    {
        $fromUser = $this->userModel->find($fromUserId);
        $toUser = $this->userModel->find($toUserId);

        if (!$fromUser || !$toUser) {
            throw new \Exception("Usuário(s) não encontrado(s).");
        }

        if ($fromUser['saldo'] < $valor) {
            throw new \Exception("Saldo insuficiente.");
        }

        $this->userModel->update($fromUserId, ['saldo' => $fromUser['saldo'] - $valor]);
        $this->userModel->update($toUserId, ['saldo' => $toUser['saldo'] + $valor]);

        $this->transactionRepository->inserirTransacao(
            $fromUserId,          
            $toUserId,          
            $valor,           
            'transferencia',      
            true            
        );
    }

   

   
}

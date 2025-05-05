<?php

namespace App\Controllers;

use App\Repository\TransactionRepository;
use App\Services\WalletService;
use App\Models\TransactionModel;
use App\Models\BalanceModel;

class CarteiraController extends BaseController
{
    protected $walletService;
    protected $transactionRepository;

    public function __construct()
    {
        $this->walletService = new WalletService();
        $this->transactionRepository = new TransactionRepository();
    }

    public function index()
    {
        $transacaoModel = new TransactionModel();

        $transacoes = $this->transactionRepository->getHistoricoPorTransacoes(session()->get('user_id'));
        $saldo = $this->transactionRepository->getSaldoAtualUsuario(session()->get('user_id'));

        return view('transaction', [
            'transacoes' => $transacoes,
            'saldo' => $saldo
        ]);
    }

    public function reverter(int $transacaoId)
    {
        $transacao = $this->transactionRepository->getById($transacaoId);

        if (!$transacao) {
            return redirect()->back()->with('error', 'Transação não encontrada!');
        }

        $valorAReverter = $transacao['valor']; 
        $usuarioId = $transacao['user_from_id']; 

        $resultado = $this->transactionRepository->updateReverteOperacoes($usuarioId, $valorAReverter);

        if ($resultado) {
            return redirect()->to('/carteira')->with('success', 'Transação revertida com sucesso!');
        } else {
            return redirect()->back()->with('error', 'Erro ao reverter a transação!');
        }
    }
    
    


    public function realizarTransacao()
    {
        $tipo = $this->request->getPost('tipo');
        $valor = floatval($this->request->getPost('valor'));
        $usuarioId = session()->get('user_id');
        $destinoId = $this->request->getPost('destino_id');

        try {
            if ($tipo === 'deposito') {

                $this->walletService->deposit($usuarioId, $valor);

            } elseif ($tipo === 'transferencia') {
                $this->walletService->transfer($usuarioId, intval($destinoId), $valor);

            }

            return redirect()->back()->with('success', 'Transação realizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}

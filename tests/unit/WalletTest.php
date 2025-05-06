<?php

namespace Tests\App\Services;

use App\Services\WalletService;
use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Repository\TransactionRepository;
use CodeIgniter\Test\CIUnitTestCase;

final class WalletTest extends CIUnitTestCase
{
    protected $walletService;

    protected $userModelMock;
    protected $transactionModelMock;
    protected $transactionRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Criando mocks das dependências
        $this->userModelMock = $this->createMock(UserModel::class);
        $this->transactionModelMock = $this->createMock(TransactionModel::class);
        $this->transactionRepositoryMock = $this->createMock(TransactionRepository::class);

        // Criando instância de WalletService com dependências mockadas
        $this->walletService = new class(
            $this->userModelMock,
            $this->transactionModelMock,
            $this->transactionRepositoryMock
        ) extends WalletService {
            public function __construct($userModel, $transactionModel, $transactionRepository)
            {
                $this->userModel = $userModel;
                $this->transactionModel = $transactionModel;
                $this->transactionRepository = $transactionRepository;
            }
        };
    }

    public function testDepositComUsuarioValido()
    {
        $userId = 1;
        $valor = 100.0;
        $user = ['id' => $userId, 'saldo' => 50.0];

        $this->userModelMock->method('find')->with($userId)->willReturn($user);

        $this->userModelMock->expects($this->once())
            ->method('update')
            ->with($userId, ['saldo' => 150.0]);

        $this->transactionRepositoryMock->method('inserirTransacao')
            ->willReturn(true);

        $this->walletService->deposit($userId, $valor);

        $this->assertTrue(true); // confirma que passou
    }

    public function testDepositUsuarioNaoEncontrado()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Usuário não encontrado.");

        $this->userModelMock->method('find')->willReturn(null);

        $this->walletService->deposit(999, 100.0);
    }

    public function testTransferenciaValida()
    {
        $fromId = 1;
        $toId = 2;
        $valor = 50.0;
    
        $this->userModelMock->method('find')->will($this->returnValueMap([
            [$fromId, ['id' => $fromId, 'saldo' => 100.0]],
            [$toId, ['id' => $toId, 'saldo' => 20.0]]
        ]));
    
        // Cria expectativa de chamadas para `update` em ordem
        $this->userModelMock->expects($this->exactly(2))
            ->method('update')
            ->with(
                $this->logicalOr(
                    $this->equalTo($fromId),
                    $this->equalTo($toId)
                ),
                $this->logicalOr(
                    $this->equalTo(['saldo' => 50.0]),
                    $this->equalTo(['saldo' => 70.0])
                )
            );
    
        $this->transactionRepositoryMock->expects($this->once())
            ->method('inserirTransacao')
            ->with($fromId, $toId, $valor, 'transferencia', true);
    
        $this->walletService->transfer($fromId, $toId, $valor);
        $this->assertTrue(true);
    }
    

    public function testTransferenciaSaldoInsuficiente()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Saldo insuficiente.");

        $this->userModelMock->method('find')->will($this->returnValueMap([
            [1, ['id' => 1, 'saldo' => 10.0]],
            [2, ['id' => 2, 'saldo' => 50.0]],
        ]));

        $this->walletService->transfer(1, 2, 100.0);
    }
}

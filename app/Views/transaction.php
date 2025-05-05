<?= $this->extend('commom/header') ?>

<?= $this->section('content') ?>

<div class="container">
    <h1>Carteira Financeira</h1>

    <!-- Exibição de Erro -->
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <!-- Exibição de Sucesso -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <!-- Formulário de Transação -->
    <form method="post" action="<?= site_url('carteira/transacao') ?>">
        <div class="form-group">
            <label for="tipo">Tipo de Transação</label>
            <select class="form-control" id="tipo" name="tipo" required>
                <option value="deposito">Depósito</option>
                <option value="transferencia">Transferência</option>
            </select>
        </div>

        <div class="form-group" id="destino-group" style="display: none;">
            <label for="destino_id">ID do Usuário Destino</label>
            <input type="number" class="form-control" id="destino_id" name="destino_id"
                placeholder="Informe o ID do destinatário">
        </div>

        <div class="form-group">
            <label for="valor">Valor</label>
            <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Realizar Transação</button>
        </div>
    </form>

    <script>
        const tipo = document.getElementById('tipo');
        const destinoGroup = document.getElementById('destino-group');

        function toggleDestinoField() {
            if (tipo.value === 'transferencia') {
                destinoGroup.style.display = 'block';
            } else {
                destinoGroup.style.display = 'none';
            }
        }

        tipo.addEventListener('change', toggleDestinoField);
        window.addEventListener('load', toggleDestinoField);
    </script>

    <!-- Tabela de Histórico de Transações -->
    <h2>Histórico de Transações</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Código</th>
                <th>Tipo</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Descrição</th>
                <th>Reversível</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transacoes as $transacao): ?>
                <tr>
                    <td><?= $transacao['user_from_id'] ?></td>
                    <td><?= ucfirst($transacao['tipo']) ?></td>
                    <td>R$ <?= number_format($transacao['valor'], 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($transacao['criado_em'])) ?></td>
                    <td><?= $transacao['tipo'] ?></td>
                    <td>
                        <?= $transacao['reversivel'] ? '<span class="text-success">Sim</span>' : '<span class="text-danger">Não</span>' ?>
                    </td>
                    <td>
                        <?php if ($transacao['reversivel']): ?>
                            <form action="<?= site_url('carteira/reverter/' . $transacao['id']) ?>" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja reverter esta transação?');">
                                <button type="submit" class="btn btn-danger">Reverter</button>
                            </form>
                        <?php else: ?>
                            <button class="btn btn-secondary" disabled>Não Reversível</button>
                        <?php endif; ?>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="alert alert-info">
        <h3>Saldo Atual: R$ <?= $saldo ?></h3>
    </div>
</div>

<?= $this->endSection() ?>
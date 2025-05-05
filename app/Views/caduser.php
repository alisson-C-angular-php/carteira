<?= $this->extend('commom/header') ?>
<?= $this->section('content') ?>

<div class="container my-5">
    <h2 class="mb-4 text-primary">Cadastrar Novo Usuário</h2>

    <form method="POST" action="/inserirUsuarios">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" name="nome" id="nome" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" required>
        </div>

        <div class="mb-3">
            <label for="senha" class="form-label">Senha</label>
            <input type="password" class="form-control" name="senha" id="senha" required>
        </div>

        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="/" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

<?= $this->endSection() ?>

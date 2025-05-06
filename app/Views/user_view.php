<?= $this->extend('commom/header') ?>
<?= $this->section('content') ?>


<div class="container my-4">
    <h1 class="mb-4 ">Gerenciamento de Registros</h1>
    
    <button class="btn btn-success mb-3" onclick="openModal()">
        Adicionar Novo
    </button>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($users) && is_array($users)): ?>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= esc($user['id']) ?></td>
                        <td><?= esc($user['nome']) ?></td>
                        <td><?= esc($user['email']) ?></td>
                        <td>
                            <button 
                                class="btn btn-sm btn-primary me-2"
                                onclick="editUser(<?= esc($user['id']) ?>, '<?= esc($user['nome']) ?>', '<?= esc($user['email']) ?>')"
                            >
                                Editar
                            </button>
                            <form method="POST" action="/deleteUser" class="d-inline">
                                <input type="hidden" name="id" value="<?= esc($user['id']) ?>">
                                <button type="submit" class="btn btn-sm btn-danger">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">Nenhum usuário encontrado.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>




<!-- Modal com Bootstrap -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="userForm" method="POST" action="/inserirUsuarios">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Adicionar Usuário</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" name="id" id="userId">

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
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script>
   function openModal() {
    const modalElement = new bootstrap.Modal(document.getElementById('userModal'));
    document.getElementById('modalTitle').innerText = 'Adicionar Usuário';
    document.getElementById('userForm').action = '/inserirUsuarios';
    document.getElementById('userId').value = '';
    document.getElementById('nome').value = '';
    document.getElementById('email').value = '';
    document.getElementById('senha').value = '';
    modalElement.show();
}

function editUser(id, nome, email) {
    const modalElement = new bootstrap.Modal(document.getElementById('userModal'));
    document.getElementById('modalTitle').innerText = 'Editar Usuário';
    document.getElementById('userForm').action = '/editarUsuario';
    document.getElementById('userId').value = id;
    document.getElementById('nome').value = nome;
    document.getElementById('email').value = email;
    document.getElementById('senha').value = '';
    modalElement.show();
}

</script>
<?= $this->endSection() ?>

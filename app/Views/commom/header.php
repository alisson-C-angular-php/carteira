<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title><?= esc($title ?? 'Meu Sistema') ?></title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .navbar-user {
            color: #fff;
            margin-left: 1rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">Meu Sistema</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/listausuarios">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/carteira">Transações</a>
                </li>
                
            </ul>

         
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <span class="navbar-user">Usuário: <?= esc(session()->get('user_name')) ?></span>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-danger ms-3" href="/">Sair</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Conteúdo principal -->
<div class="container mt-5">
    <?= $this->renderSection('content') ?>
</div>

</body>
</html>

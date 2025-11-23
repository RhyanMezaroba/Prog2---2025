<?php
// NÃO usar session_start() na view — já iniciado pelo controller.

// Recebe flash, old, errors passados pelo controller (ou via session)
$flash = $flash ?? [];
$errors = $errors ?? [];
$old = $old ?? [];

// se por algum motivo ainda houver flash na sessão direta, capta e limpa
if (isset($_SESSION['flash'])) {
    $flash = array_merge($flash, $_SESSION['flash']);
    unset($_SESSION['flash']);
}
?>

<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login</title>
    <style>
        body { font-family: Arial, sans-serif; padding:20px; max-width:480px; margin:0 auto; }
        .form-group { margin-bottom:12px; }
        label { display:block; margin-bottom:4px; font-weight:600; }
        input[type="email"], input[type="password"] { width:100%; padding:8px; box-sizing:border-box; }
        .error { color:#c00; font-size:0.9em; }
        .alert { padding:10px; margin-bottom:12px; border-radius:4px; }
        .alert-success { background:#e6ffea; color:#006633; }
        .alert-error { background:#ffecec; color:#990000; }
        .actions { margin-top:16px; }
        .btn { padding:10px 14px; border:none; background:#0366d6; color:#fff; cursor:pointer; border-radius:4px; }
        .btn-secondary { background:#6c757d; color:#fff; padding:10px 14px; border-radius:4px; text-decoration:none; display:inline-block; }
    </style>
</head>
<body>

    <h1>Entrar</h1>

    <?php if (!empty($flash['success'])): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($flash['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($flash['error'])): ?>
        <div class="alert alert-error"><?php echo htmlspecialchars($flash['error']); ?></div>
    <?php endif; ?>

    <form method="post" action="/DoaSys/app/migration/router.php?c=auth&a=login">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input id="email" name="email" type="email" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>">
            <?php if (!empty($errors['email'])): ?><div class="error"><?php echo htmlspecialchars($errors['email']); ?></div><?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input id="password" name="password" type="password">
            <?php if (!empty($errors['password'])): ?><div class="error"><?php echo htmlspecialchars($errors['password']); ?></div><?php endif; ?>
        </div>

        <div class="actions">
            <button type="submit" class="btn">Entrar</button>
            <a href="/DoaSys/app/migration/router.php?c=auth&a=showRegister" class="btn-secondary" style="margin-left:8px;">Criar conta</a>
        </div>
    </form>

</body>
</html>
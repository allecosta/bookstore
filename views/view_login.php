<?php require_once '../controllers/login.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main class="container-fluid text-center text-capitalize">
        <h1>Seja Bem vindo a Book Store! Faça o seu login</h1>
        <form action="/controllers/login.php" method="POST">
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">E-mail </label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" value="<?= $infos['email']; ?>" required>
                    <label class="text-danger">
                        <?= $msg_errors['email']; ?>
                    </label>
                </div>   
            </div>
            <div class="row mb-3">
                <label class="col-sm-2 col-form-label">Senha </label>
                <div class="col-sm-10">
                    <input type="password" name="pass" class="form-control" required>
                    <label class="text-danger">
                        <?php echo $msg_errors['pass']; ?>
                    </label>
                </div>    
            </div>
            <?php if (isset($_GET['buy'])) : ?>
                <input type="hidden" name="buy" value="<?= clear($_GET['buy']); ?>">
            <?php endif ?>

            <div class="container">
                <button type="submit" class="btn btn-primary">Entrar</button>
            </div>
            <div class="container">
                <p>Já possui uma conta?<a href="view_create_account.php"> Registre-se</a></p>
            </div>
        </form>
    </main>
</body>
</html>


<?php require_once '../controllers/login.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main class="container-fluid text-center text-capitalize">
        <h1>Seja Bem vindo a Book Store! Faça o seu login</h1>
        <form action="/controllers/login.php" method="POST">
            <div class="container row col-12 css-input-box">
                <label class="col-12 col-md-4 text-center">
                    <div class="col-12 col-md-8">
                    Email: <input type="email" name="email" placeholder="informe o seu email" value="<?php echo $infos['email']; ?>" required>
                            <label class="text-danger">
                                <?= $msg_errors['email']; ?>
                            </label>
                    </div>
                </label>
            </div>
            <div class="container row col-12 css-input-box">
                <label class="col-12 col-md-4 text-center">
                    <div class="col-12 col-md-8">
                    Senha: <input type="password" name="pass" placeholder="informe a sua senha" required>
                        <label class="text-danger">
                            <?php echo $msg_errors['pass']; ?>
                        </label>
                    </div>
                </label>
            </div>

            <?php if (isset($_GET['buy'])) : ?>
                <input type="hidden" name="buy" value="<?php echo clear($_GET['buy']); ?>">
            <?php endif ?>

            <div class="container">
                <input type="submit" class="btn btn-primary" value="Entrar">
            </div>
            <div class="container">
                <p>Já possui uma conta?<a href="view_create_account.php"> Registre-se</a></p>
            </div>
        </form>
    </main>
</body>
</html>


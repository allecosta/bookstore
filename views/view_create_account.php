<?php require_once '../controllers/create_account.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">

<?php require_once '../templates/head.php'; ?>

<body>

<?php require 'header.php'; ?>

    <main>
        <section class="container">
            <div class="text-center">
                <h1>Criar conta na Book Store</h1>
                <p>Preencha os dados abaixo para criar a sua conta</p>
            </div>
            <form action="" method="POST">
                <div>
                    <label>
                        Nome Completo
                        <input type="text" name="name" placeholder="Informe o seu nome completo"
                        value="<?php echo $infos['name']; ?>" required> 
                    </label>
                    <label class="css-msg-error">
                        <?php echo $msg_errors['name']; ?>
                    </label>
                </div>
                <div>
                    <label>
                        E-mail 
                        <input type="email" name="email" placeholder="Informe o seu email"
                        value="<?php echo $infos['email']; ?>" required>
                    </label>
                    <label class="css-msg-error">
                        <?php echo $msg_errors['email']; ?>
                    </label>
                </div>
                <div>
                    <label>
                        Senha 
                        <input type="password" name="pass" placeholder="Informe a sua senha com 8 caracteres"
                        value="<?php echo $infos['pass']; ?>" required maxlength="8">
                    </label>
                    <label class="css-msg-error">
                        <?php echo $msg_errors['pass']; ?>
                    </label>
                </div>
                <div>
                    <label>
                        Confirmação de senha
                        <input type="password" name="confir_pass" placeholder="Repita a senha informada..."
                        value="<?php echo $infos['confir_pass']; ?>" required>
                    </label>
                    <label class="css-msg-error">
                        <?php echo $msg_errors['confir_pass']; ?>
                    </label>
                </div>

                <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Cadastrar">
            </form>
        </section>
    </main>
    
</body>
</html>
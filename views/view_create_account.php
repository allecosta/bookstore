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
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Nome </label>
                    <div class="col-sm-10">                
                        <input type="text" name="name" class="form-control" placeholder="Informe o seu nome completo"
                        value="<?= $infos['name']; ?>" required> 
                        <label class="css-msg-error">
                            <?php echo $msg_errors['name']; ?>
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">E-mail </label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control" placeholder="Informe o seu email"
                            value="<?= $infos['email']; ?>" required>
                        <label class="css-msg-error">
                            <?= $msg_errors['email']; ?>
                        </label>
                    </div>     
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Senha </label>
                    <div class="col-sm-10">
                        <input type="password" name="pass" class="form-control" placeholder="Informe a sua senha com 8 caracteres"
                        value="<?= $infos['pass']; ?>" required maxlength="8">
                        <label class="css-msg-error">
                            <?= $msg_errors['pass']; ?>
                        </label>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-2 col-form-label">Confirme a senha </label>
                    <div class="col-sm-10">
                        <input type="password" name="confir_pass" class="form-control" placeholder="Repita a senha informada"
                        value="<?= $infos['confir_pass']; ?>" required>
                        <label class="css-msg-error">
                            <?= $msg_errors['confir_pass']; ?>
                        </label>
                    </div>
                </div>
                <div class="container">
                    <button type="submit" id="submit" class="btn btn-primary" name="submit">Cadastrar</button>
                </div> 
            </form>
        </section>
    </main>   
</body>
</html>
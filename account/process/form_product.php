<section class="container col-12 col-sm-8 col-md-9 col-lg-10">
    <div class="text-center">
        <?php if ($page === "buy") : ?>
            <h1>Cadastrar Novo Produto</h1>
            <p>Preencha os campos abaixo para colocar o seu produto à venda: </p>

        <?php elseif ($page === "edit") : ?>
            <h1>Editar Produto</h1>
            <p>Preencha os campos abaixo para editar o seu produto: </p>
        <?php endif; ?>
    </div>
    <form action="" id="info-product" method="POST" enctype="multipart/form-data">
        <div class="container row col-12 css-input-box">
            <div class="col-12 col-md-8">
                <input type="text" 
                    name="title_product" 
                    placeholder="Insira o nome do produto" 
                    value="<?= $dataProduct['title']; ?>"
                    >
                <label class="col-12 css-msg-error">
                    <?= $msg_errors['title']; ?>
                </label>
            </div>
        </div>
        <div class="container row col-12 css-input-box">
            <label class="col-12 col-md-4 text-center" title="Quantidade em estoque">Quantidade em Estoque: </label>
            <div class="col-12 col-md-8">
                <input type="number" name="quantity"
                    min="1" max="99"
                    value="<?= $dataProduct['quantity']; ?>"
                >
                <label class="col-12 css-msg-error">
                    <?= $msg_errors['quantity']; ?>
                </label>
            </div>
        </div>
        <div class="container row col-12 css-input-box">
            <label class="col-12 col-md-4 text-center" title="Preço do produto">Preço: R$</label>
            <div class="col-12 col-md-8">
                <input type="text" name="price"
                    min="0" max="100000"
                    value="
                        <?php
                        
                        if ($_SERVER['REQUEST_METHOD'] === "POST") {
                            echo formatPrice($dataProduct['price']);
                        } else {
                            echo $dataProduct['price'];
                        }

                        ?>"
                >
                <label class="col-12 css-msg-error">
                    <?= $msg_errors['price']; ?>
                </label>
            </div>
        </div>
        <div class="container row col-12 css-input-box">
            <label class="col-12 col-md-4 text-center" 
                title="Descreva o seu produto em detalhes!">Descrição do Produto: 
            </label>
            <div class="col-12 col-md-8">
                <textarea required name="descriptiton"><?= $dataProduct['description']; ?></textarea>
                <label class="col-12 css-msg-error">
                    <?= $msg_errors['description']; ?>
                </label>
            </div>
        </div>

        <?php if ($page === "buy") : ?>
            <div class="container text-center css-input-box">
                <input type="submit" id="submit" class="btn btn-primary" name="submit" value="Cadastrar">
            </div>

        <?php elseif ($page === "edit") : ?>
            <div class="text-center">
                <input type="submit" id="submit" name="submit" value="Salvar">
                <a href="view_account.php?link=my_products">Cancelar</a>
                <input type="hidden" name="id_product" value="<?= $dataProduct['id_product']; ?>">
            </div>
        <?php endif; ?>
    </form>
</section>
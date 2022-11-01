<header class="container-fluid row">
    <div id="logo" class="container-fluid col-12 col-md-6">
        <p>BOOK STORE</p>
    </div>
    <nav id="main-nav" class="container-fluid col-12 col-md-6">
        <ul class="nav justify-content-center">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="view_account.php?link=sell">Vender</a>
            </li>

            <?php if (!isset($_SESSION['id_user'])) : ?>
                <li class="nav-item"><a class="nav-link" href="view_login.php">Fazer Login</a></li>
            <?php else : ?>
                <li class="nav-item"><a class="nav-link" href="view_account.php?link=cart">Carrinho</a></li>
                <li class="nav-item"><a class="nav-link" href="view_account.php">Minha Conta</a></li>
                <li class="nav-item"><a class="nav-link" href="exit.php">Sair</a></li>
            <?php endif; ?>
        </ul>
    </nav>
    <form id="search" class="form-inline input-group" action="view_search.php" method="GET">
        <input class="form-control" type="text" name="search" placeholder="O que você procura?">
        <div class="input-group-append">
            <input class="btn btn-" type="submit" value="Pesquisar">
        </div>
    </form>
</header>
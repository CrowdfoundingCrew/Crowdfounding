<nav class="navbar navbar-expand-custom navbar-mainbg">
    <a class="navbar-brand navbar-logo" href="#">Donate For</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <div class="hori-selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <?php if (!isset($_SESSION['Username'])) {
            ?>
                <li class="nav-item active">
                    <a class="nav-link active" href="/public/index.php">Homepage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 5</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login <i class="fas fa-sign-in-alt"></i></a>
                </li>
            <?php } else { ?>
                <li class="nav-item active">
                    <a class="nav-link active" href="/public/index.php">HomePage</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 3</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link 4</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/admin/allonlus.php">Impostazioni account</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><?= $_SESSION['Username'] ?> <i class="fas fa-sign-out-alt"></i></a>
                </li>
            <?php } ?>
        </ul>
    </div>
</nav>
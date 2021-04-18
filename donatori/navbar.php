<nav class="navbar navbar-expand-custom navbar-mainbg">
    <a class="navbar-brand navbar-logo" href="/public/index.php">Donate For</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <i class="fas fa-bars text-white"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ml-auto">
            <div class="hori-selector">
                <div class="left"></div>
                <div class="right"></div>
            </div>
            <li class="nav-item">
                <a class="nav-link" href="/public/index.php">HomePage</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/public/index.php">Tutti i progetti</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link active" href="/donatori/profile.php?ID=<?= $_SESSION['ID'] ?>">Profilo</a>
            </li>
            <div class="nav-item form-inline ml-5">
                <a class="nav-link text-light" href="/public/logout.php"><?=$_SESSION['Username']?><i class="fas fa-sign-out-alt ml-2"></i></a>
            </div>
        </ul>
    </div>
</nav>
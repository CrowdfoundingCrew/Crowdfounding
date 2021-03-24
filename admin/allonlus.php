<?php 
    //include 'checksession.php';
    include 'mysql.php';
    $title = 'Questo è un titolo';
    $footer = 'Questo è un footer';
    $page = 1;
    include 'header.php';
    include 'navbar.php';
    
    if (isset($_GET['pageno'])) {
        $pageno = $_GET['pageno'];
    } else {
        $pageno = 1;
    }

    $no_of_records_per_page = 2;
    $offset = ($pageno - 1) * $no_of_records_per_page; 
    $data = Pagination($no_of_records_per_page, $offset);
?>
<body>
    <div class="container-xl">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between my-2">                 
                <div class="page-header">
                    <h1><?=$title?></h1>
                </div>
                    <form class="form-inline">
                        <input class="form-control mr-sm-2" type="text">
                        <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="bi bi-search"></i>Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>
                    ONLUS 1
                </h3>
                <p>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
                </p>
                <p>
                    <a class="btn" href="#">View details »</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <img alt="Bootstrap Image Preview" src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg">
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 75%">
                    </div>
                </div>
                <address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
                <blockquote class="blockquote">
                    <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>
                    <footer class="blockquote-footer">
                        Someone famous in <cite>Source Title</cite>
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <img alt="Bootstrap Image Preview" src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg">
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" style="width: 13%">
                    </div>
                </div>
                <address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
                <blockquote class="blockquote">
                    <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>
                    <footer class="blockquote-footer">
                        Someone famous in <cite>Source Title</cite>
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <img alt="Bootstrap Image Preview" src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg">
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" style="width: 90%">
                    </div>
                </div>
                <address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
                <blockquote class="blockquote">
                    <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>
                    <footer class="blockquote-footer">
                        Someone famous in <cite>Source Title</cite>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>
                    ONLUS 2
                </h3>
                <p>
                    Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.
                </p>
                <p>
                    <a class="btn" href="#">View details »</a>
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <img alt="Bootstrap Image Preview" src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg">
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-warning" style="width: 34%">
                    </div>
                </div>
                <address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
                <blockquote class="blockquote">
                    <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>
                    <footer class="blockquote-footer">
                        Someone famous in <cite>Source Title</cite>
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <img alt="Bootstrap Image Preview" src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg">
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" style="width: 100%">
                    </div>
                </div>
                <address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
                <blockquote class="blockquote">
                    <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>
                    <footer class="blockquote-footer">
                        Someone famous in <cite>Source Title</cite>
                    </footer>
                </blockquote>
            </div>
            <div class="col-md-4">
                <img alt="Bootstrap Image Preview" src="https://www.layoutit.com/img/sports-q-c-140-140-3.jpg">
                <div class="progress mt-2">
                    <div class="progress-bar progress-bar-animated progress-bar-striped bg-info" style="width: 68%">
                    </div>
                </div>
                <address>
				 <strong>Twitter, Inc.</strong><br> 795 Folsom Ave, Suite 600<br> San Francisco, CA 94107<br> <abbr title="Phone">P:</abbr> (123) 456-7890
			</address>
                <blockquote class="blockquote">
                    <p class="mb-0">
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.
                    </p>
                    <footer class="blockquote-footer">
                        Someone famous in <cite>Source Title</cite>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-around">
                    <nav>
                        <ul class="pagination">
                            <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                            <li class="page-item <?php if($pageno <= 1){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                            </li>
                            <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                                <a class="page-link" href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                            </li>
                            <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/scripts.js"></script>
<?php
    include 'footer.php';
?>
    </body>
<?php
//TODO
//TODO query
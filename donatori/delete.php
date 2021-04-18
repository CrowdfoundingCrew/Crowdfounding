<?php
include('checksession.php');
require('../config/dalDonatori.php');
$id = isset($_SESSION['ID']) ? $_SESSION['ID'] : header('Location: /public'); ;

DELETEDonatori($id);

header('Location: /public/logout.php'); 
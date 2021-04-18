<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paypal Integration</title>
</head>

<body>

    <form class="paypal" action="payments.php" method="post" id="paypal_form">
        <input type="hidden" name="cmd" value="_xclick" />
        <input type="hidden" name="no_note" value="1" />
        <input type="hidden" name="lc" value="EU" />
        <input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
        <input type="hidden" name="progetto" value="<?=$_GET["prjname"]; ?>" />
        <input type="hidden" name="donazione" value="<?=$_GET["don"]; ?>" />
        <input type="hidden" nome="userid" volue="
        <?php 
        session_start();
        echo $_SESSION["ID"];
        ?>" />
        <input type="hidden" nome="prjid" volue="<?=$_GET["prjid"]; ?>" />
    </form>
    <script type="text/javascript">
        document.getElementById("paypal_form").submit();
    </script>
</body>

</html>
<?php
$tipousuario = $_SESSION['auth']['tipo'];
if($tipousuario == "1")
    {
        require_once '/var/www/WebMarketTest/views/layouts/headerempresa.php';
    }
    elseif($tipousuario == "2")
    {
        require_once '/var/www/WebMarketTest/views/layouts/headerpersonal.php';
    }
?>


<h1> cuentas </h1>

<?php require_once '/var/www/WebMarketTest/views/layouts/footerempresa.php'; ?>
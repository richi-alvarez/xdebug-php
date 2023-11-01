<?php
include_once("includes/mysql_connect.php");
include_once("includes/Tiendanube.php");

$tiendanube= new Tiendanube();
$algo = $tiendanube->getPaymentProviderData("3197368", "7322");
echo "epayco-tiendanube";
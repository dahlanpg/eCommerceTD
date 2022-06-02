<?php

    setcookie("cart", $jsonProducts, time() - (86400 * 7), "/");
    setcookie("qtd", $jsonProducts, time() - (86400 * 7), "/");

?>
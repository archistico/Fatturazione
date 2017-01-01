<?php

include "../php/utilita.php";

echo "PAGINA TEST";

$a = "prova'ciao";
echo pulisciStringa($a);
echo str_replace('"', '', $a);
<?php

function convertiStringaToHTML($stringa) {
    return htmlentities($stringa, ENT_COMPAT,'ISO-8859-1', true);
}

function convertiHTMLToStringa($stringa) {
    return htmlspecialchars($stringa, ENT_COMPAT,'ISO-8859-1', true);
}

?>
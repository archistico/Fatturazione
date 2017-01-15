<!DOCTYPE html>
<html>
<body>

<?php
$str = " Hello World!  ";
echo "Without trim: -".$str."-";
echo "<br>";
echo "With trim: -".trim($str)."-";
echo "<br>";
echo "Substring 6: -".substr(trim($str),0,6)."-";
?>

</body>
</html>
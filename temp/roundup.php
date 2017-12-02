<!DOCTYPE html>
<html>
<body>

<script>
function roundup(num,dec){
    dec= dec || 0;
    var  s=String(num.toFixed(dec+1));
    if(num%1)s= s.replace(/5$/, '6');
    return Number((+s).toFixed(dec)).toFixed(dec);
}

 var n= 35.555;
 console.log(n.toFixed(2));
 console.log(roundup(n,2));

</script>

</body>
</html>
<style>
.content {display:none;}
.preload { width:100px;
    height: 100px;
    position: fixed;
    top: 50%;
    left: 50%;}

</style>
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script>
$(function() {
    $(".preload").fadeOut(2000, function() {
        $(".content").fadeIn(1000);        
    });
});
</script>
</head>
<body>

<div class="preload"><img src="http://devsite1.altoqi.com.br/projeto-crashfix/load.gif">
</div>
<div class="content">I would like to display a loading bar before the entire page is loaded. For now, I'm just using a small delay:

$(document).ready(function(){
    $('#page').fadeIn(2000);
});
The page already uses jquery.

Note: I have tried this, but it didn't work for me:

loading bar while script runs

I also tried other solutions. In most cases, the page loads as usually or the page won't load/display at all.

Thank you for any help.</div>

</body>
</html>

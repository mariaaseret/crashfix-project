<style type="text/css">

    input[type=text] {
        padding:5px; 
        border:2px solid #ccc; 
        -webkit-border-radius: 5px;
        border-radius: 5px;
    }

    input[type=text]:focus {
        border-color:#333;
    }

    input[type=submit] {
        padding:5px 15px; 
        background:#ccc; 
        border:0 none;
        cursor:pointer;
        -webkit-border-radius: 5px;
        border-radius: 5px; 
    }
</style>
<?php

$conn = new mysqli('34.225.230.59', 'crashfix', 'Cr9999aq', 'crashfix') 
    or die ('Cannot connect to db');


//CONSULTAS NO BANCO

(isset($_POST["submit"])) ? $periodo = $_POST["SelecaoAno"] : $periodo=10;


$qTop50="SELECT ipaddress, emailfrom, count(tbl_crashreport.id) AS 'total' FROM tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and (tbl_appversion.version not like '(not set)') GROUP BY ipaddress ORDER BY total DESC LIMIT 50";
$rTop50=mysqli_query($conn,$qTop50);
$i = 0;
if($rTop50)
{
    while($row=mysqli_fetch_assoc($rTop50))
    {
        $ip[$i] = $row['ipaddress'];
        $iemail[$i] = $row['emailfrom'];
        $total[$i] = $row['total'];
    }     
}

$qTop50Ultimos="SELECT ipaddress, emailfrom, count(tbl_crashreport.id) AS 'total' FROM tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  and  date(FROM_UNIXTIME(tbl_crashreport.date_created)) >= DATE(NOW()) - INTERVAL '$periodo' DAY and  tbl_appversion.version not like 'null') and (tbl_appversion.version not like '(not set)') GROUP BY ipaddress ORDER BY total desc LIMIT 50";
$rTop50Ultimos=mysqli_query($conn,$qTop50Ultimos);
$i = 0;
if($rTop50Ultimos)
{
    while($row=mysqli_fetch_assoc($rTop50Ultimos))
    {
        $ipUltimos[$i] = $row['ipaddress'];
        $iemailUltimos[$i] = $row['emailfrom'];
        $totalUltimos[$i] = $row['total'];
        $i++;
    }
}

echo 'oii ';

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Trasitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="txt/html; charset=utf-8" />
        <title>Relatórios Crashfix do Suporte</title>
        <link rel="shortcut icon" href="https://www.altoqi.com.br/wp-content/uploads/2017/10/cropped-favicon-01.png" type="image/x-icon" 

              <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.js"></script>
    <script type="text/javascript"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['table']});
        google.charts.setOnLoadCallback(drawTable);
        var row, col;
        function drawTable() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Name');
            data.addColumn('number', 'Crashes');
            data.addRows([
                <?php
                for($i=0;$i<50;$i++){
                    echo "['" . $iemailUltimos[$i] . "'," . $totalUltimos[$i] . "],";
                } 
                ?>
            ]);
            var table = new google.visualization.Table(document.getElementById('table_div'));

            google.visualization.events.addListener(table, 'select', function(){
                selectHandler(table);
            });

            function selectHandler(table) {
                var selection = table.getSelection();
                if(selection.length === 0)
                    return;

                var cell = event.target; //get selected cell
                row = selection[0].row;
                col = cell.cellIndex;
                document.getElementById('output').innerHTML = "Row: " +  selection[0].row + " Column: " +  cell.cellIndex;

            }

            table.draw(data, {showRowNumber: true, allowHtml: true, width: '95%', height: '100%'});

        }
    </script>

    </head>
<body>
    <table class="columns">
        <tr>
            <td>
                <p style="font-family: 'Lato', Helvetica, Arial, sans-serif; margin-left: 70px; "><b>Selecione o período desejado</b></p>

                <form  method="post" style="margin-left:70px">

                    <select id="SelecaoAno" name="SelecaoAno">
                        <option value="selecione"  <?php if ($periodo == 2015 )  echo 'selected'; ?>>Período</option>
                        <option value="10" <?php if ($periodo == 10 )  echo 'selected'; ?>>últimos 10 dias</option>
                        <option value="20" <?php if ($periodo == 20 )  echo 'selected'; ?>>últimos 20 dias</option>
                        <option value="30" <?php if ($periodo == 30 )  echo 'selected'; ?>>últimos 30 dias</option>
                        <option value="40" <?php if ($periodo == 40 )  echo 'selected'; ?>>últimos 40 dias</option>
                        <option value="50" <?php if ($periodo == 50 )  echo 'selected'; ?>>últimos 50 dias</option>
                    </select>
                    <input type="submit" name="submit" value="Selecionar"/>
                </form>
            </td>
        </tr>
    </table>
    <?php
    $path = 'tabela.php';
    //include($path); ?>

    <div id="table_div"></div> 
    <div id="output"></div>

</body>
</html>

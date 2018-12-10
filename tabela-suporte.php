<style>
    .table-row-odd, .table-row-odd:hover {
        background-color: #e3f4ff !important;
    }

    tbody tr {
        cursor: pointer;
    }
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



$qTop50Ultimos="SELECT ipaddress, emailfrom, tbl_crashreport.project_id, date_created, count(tbl_crashreport.id) AS 'total' FROM tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  and  date(FROM_UNIXTIME(tbl_crashreport.date_created)) >= DATE(NOW()) - INTERVAL '$periodo' DAY and  tbl_appversion.version not like 'null') and (tbl_appversion.version not like '(not set)') GROUP BY ipaddress ORDER BY total desc LIMIT 50";
$rTop50Ultimos=mysqli_query($conn,$qTop50Ultimos);
$i = 0;
if($rTop50Ultimos)
{
    while($row=mysqli_fetch_assoc($rTop50Ultimos))
    {
        $ipUltimos[$i] = $row['ipaddress'];
        $dataUltimos[$i] = $row['date_created'];
        $emailUltimos[$i] = $row['emailfrom'];
        $projectIdUltimos[$i] = $row['project_id'];
        $totalUltimos[$i] = $row['total'];

        $i++;
    }
}


$qEspecificacoes="SELECT * FROM tbl_crashreport  where  date(FROM_UNIXTIME(tbl_crashreport.date_created)) >= DATE(NOW()) - INTERVAL 40 DAY  and ipaddress = '$ipUltimos'  ORDER BY tbl_crashreport.date_created desc";
$rEspecificacoes=mysqli_query($conn,$qEspecificacoes);
$i = 0;
if($rTop50Ultimos)
{
    while($row=mysqli_fetch_assoc($rEspecificacoes))
    {
        $ipUltimos[$i] = $row['ipaddress'];
        $dataUltimos[$i] = $row['date_created'];
        $emailUltimos[$i] = $row['emailfrom'];
        $projectIdUltimos[$i] = $row['project_id'];
        $totalUltimos[$i] = $row['total'];

        $i++;
    }
}


echo 'oiia ';

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Trasitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="txt/html; charset=utf-8" />
        <title>Relatórios Crashfix do Suporte</title>
        <link rel="shortcut icon" href="https://www.altoqi.com.br/wp-content/uploads/2017/10/cropped-favicon-01.png" type="image/x-icon" >
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.2.3/foundation.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/foundation/6.3.0/css/foundation.min.css">
        <script type="text/javascript">

            $(document).ready(function () {  // you do not need document.ready in your foundation project

                // function to remove and add alt row classes
                var updateAltRowClasses = function updateAltRowClasses() {
                    $('tbody tr').removeClass('table-row-odd'); // remove all alt row classes
                    $('tbody tr:odd').addClass('table-row-odd'); // add class to alt rows
                }

                updateAltRowClasses(); // run function to add classes to alternating table rows


                // toggle-able row
                $('tbody tr').not('.hidden-row').on('click', function(){ // table row is clicked
                    var hiddenRow = $(this).next(".hidden-row"); // variable that finds the hidden content for clicked row
                    var rowExists = $(hiddenRow).length; // variable that figures out if the collapsible row already exists or not
                    if (rowExists) { // if collapsible row exists already
                        $('tbody .hidden-row').not(hiddenRow).hide(); // hide all open toggle-able rows
                        $(hiddenRow).toggle(); // toggle the row on and off
                    } else { // if collapsible row doesn't exist
                        var expRowContent = $(this).find('.hide').html(); // grab this row's hidden content and store in a variable
                        var newExpRow = '<tr class="hidden-row" style="display:none;"><td colspan="5">' + expRowContent + '</td></tr>'; // wrap hidden content in a table row
                        $(newExpRow).insertAfter(this); // insert the collapsible table row after the clicked row
                        $('tbody .hidden-row').not(hiddenRow).hide(); // hide all open toggle-able rows
                        $(this).next('.hidden-row').toggle();  // toggle the row on and off
                    }
                });

                // list.js settings
                var options = {
                    valueNames: [ 'TL-transaction-date', 'TL-transaction-name', 'TL-transaction-account-number', 'TL-transaction-type', 'TL-transaction-amount' ]
                };

                var userList = new List('breeze-transaction-list', options); // initiate list.js
                userList.on('updated', updateAltRowClasses); // update alternate row classes after every new sort
            });
        </script>
    </head>
    <body>


        <p style="font-family: 'Lato', Helvetica, Arial, sans-serif; margin-left: 70px; "><b>Selecione o período desejado</b></p>

        <form  method="post" style="margin-left:70px">

            <select id="SelecaoAno" name="SelecaoAno">
                <option value="10" <?php if ($periodo == 10 )  echo 'selected'; ?>>últimos 10 dias</option>
                <option value="20" <?php if ($periodo == 20 )  echo 'selected'; ?>>últimos 20 dias</option>
                <option value="30" <?php if ($periodo == 30 )  echo 'selected'; ?>>últimos 30 dias</option>
                <option value="40" <?php if ($periodo == 40 )  echo 'selected'; ?>>últimos 40 dias</option>
                <option value="50" <?php if ($periodo == 50 )  echo 'selected'; ?>>últimos 50 dias</option>
            </select>
            <input type="submit" name="submit" value="Selecionar"/>
        </form>


        <div class="row" id="breeze-transaction-list">
            <div class="columns small-12">
                <table role="grid" class="hover">
                    <thead>
                        <tr>
                            <th class="sort" data-sort="TL-transaction-date">Date</th>	
                            <th class="sort TL-mobile-hide" data-sort="TL-transaction-name">E-mail</th>
                            <th class="sort TL-mobile-hide" data-sort="TL-transaction-account-number">IP</th>
                            <th class="sort" data-sort="TL-transaction-type">Projeto</th>
                            <th class="sort" data-sort="TL-transaction-amount">Total</th>					 
                        </tr>
                    </thead>
                    <tbody class="list">
                        <?php  for($i=0;$i<50;$i++){
                        ?>
                        <tr>
                            <td class="TL-transaction-date"><?php  echo date('d/m/Y', $dataUltimos[$i]); ?></td>
                            <td class="TL-transaction-name"><?php echo $emailUltimos[$i]; ?></td>
                            <td class="TL-transaction-account-number"><?php echo $ipUltimos[$i]; ?></td>
                            <td class="TL-transaction-type"><?php echo $projectIdUltimos[$i]; ?></td>
                            <td class="TL-transaction-amount"><?php echo $totalUltimos[$i]; ?>
                                <div class="hide">
                                    Especificações
                                    <table>
                                        <tr>
                                            <td>Trompedte</td>
                                            <td>Trombone</td>
                                            <td>Trombone</td>
                                            <td>Trombone</td>
                                        </tr>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>

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
//exibe o contador diretamente do banco

/*$conn = new mysqli('192.168.10.12', 'crashfix', 'd&U2Opi#=2a8', 'crashfix') 
    or die ('Cannot connect to db');*/

$conn = new mysqli('34.225.230.59', 'crashfix', 'Cr9999aq', 'crashfix') 
    or die ('Cannot connect to db');


//PARA O GRÁFICO MENSAL

(isset($_POST["submit"])) ? $anoselecionado = $_POST["SelecaoAno"] : $anoselecionado=2018;

$messelecionado = 01;




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Trasitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="txt/html; charset=utf-8" />
        <title>Gráficos e Relatórios Crashfix</title>
        <link rel="shortcut icon" href="https://www.altoqi.com.br/wp-content/uploads/2017/10/cropped-favicon-01.png" type="image/x-icon" 

              <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

    </head>



<body>
    <table class="columns">
        <tr>
            <td>
                <p style="font-family: 'Lato', Helvetica, Arial, sans-serif; "><b>Selecione o ano desejado</b></p>

                <form  method="post">

                    <select id="SelecaoAno" name="SelecaoAno">
                        <option value="selecione"  <?php if ($anoselecionado == 2015 )  echo 'selected'; ?>>Ano</option>
                        <option value="2017" <?php if ($anoselecionado == 2017 ) echo 'selected'; ?>>2017</option>
                        <option value="2018" <?php if ($anoselecionado == 2018 )  echo 'selected'; ?>>2018</option>
                        <option value="2019" <?php if ($anoselecionado == 2019 )  echo 'selected'; ?>>2019</option>
                    </select>
                    <input type="submit" name="submit" value="Selecionar"/>
                </form>

                <?php

                if(isset($_POST['submit'])) {
                    $anoselecionado = $_POST['SelecaoAno'];
                }// VARIAVEL SELECIONADA


                //PARA O GRÁFICO MENSAL

                $query5="select count(tbl_crashreport.id) as e from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and (tbl_appversion.version not like '(not set)')";
                $result5=mysqli_query($conn,$query5);
                $query6="select count(tbl_crashreport.id) as f from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and (tbl_appversion.version not like '(not set)')";
                $result6=mysqli_query($conn,$query6);
                $query7="select count(tbl_crashreport.id) as g from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and (tbl_appversion.version not like '(not set)')";
                $result7=mysqli_query($conn,$query7);


                ?>


                <?php


                $eberick = 1 ;
                $qibuilder = 1 ;
                $qicad = 1 ;

                if($result5)
                {
                    while($row=mysqli_fetch_assoc($result5))
                    {
                        $eberick = $row['e'];
                    }     
                }
                if($result6)
                {
                    while($row=mysqli_fetch_assoc($result6))
                    {
                        $qibuilder = $row['f'];
                    }     
                }
                if($result7)
                {
                    while($row=mysqli_fetch_assoc($result7))
                    {
                        $qicad = $row['g'];
                    }     
                }

                echo '<br/>';
                $soma2 = $eberick + $qibuilder + $qicad;


                if($eberick != 0){
                    $porcentagemeberick = (100*$eberick)/$soma2;
                }else{
                    $porcentagemeberick = 0;
                }

                if($qibuilder != 0){
                    $porcentagemqibuilder = (100*$qibuilder)/$soma2;    
                }else {
                    $porcentagemqibuilder = 0;
                }

                if($qicad != 0) {
                    $porcentagemqicad = (100*$qicad)/$soma2;    
                }else{
                    $porcentagemqicad = 0;
                }



                ?>

                <script type="text/javascript">
                    google.charts.load('current', {packages: ['corechart']});
                    google.charts.setOnLoadCallback(drawChart2);

                    function drawChart2() {
                        // Define the chart to be drawn.
                        var data = new google.visualization.DataTable();
                        data.addColumn('string', 'Element');
                        data.addColumn('number', 'Percentage');
                        data.addRows([
                            ['Eberick: <?php echo $eberick?>', <?php echo $porcentagemeberick?>],
                            ['Qibuilder: <?php echo $qibuilder?>',  <?php echo $porcentagemqibuilder?>],
                            ['Qicad: <?php echo $qicad?>',  <?php echo $porcentagemqicad?>]
                        ]);


                        var options = {
                            colors: ['#335E52', '#2CA871', '#6FEDC0'],
                            title: 'Crashes de <?php echo $anoselecionado?>',
                            is3D: true,
                        };

                        // Instantiate and draw the chart.
                        var chart = new google.visualization.PieChart(document.getElementById('myPieChart2'));
                        chart.draw(data, options);
                    }
                </script>



                <br/>


                <?php
    if(($eberick + $qibuilder + $qicad != 0)  ){
                ?>
                <div id="myPieChart2" style="border: 1px;   height: 200px; width: 500px;"></div></td>
            <?php
    }else{
            ?>
            <div> Resultado = zero </div></td>
    <?php
    }
    ?>
    </tr>
</table>


<?php 
//CONSULTAS EBERICK----------------------------------------------------------------------
//JANEIRO
$query12="select count(tbl_crashreport.id) as p from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 01 and (tbl_appversion.version not like '(not set)')";
$result12=mysqli_query($conn,$query12);
if($result12)
{
    while($row=mysqli_fetch_assoc($result12))
    {
        $janeiro = $row['p'];
    }     
}
//FEVEREIRO
$query13="select count(tbl_crashreport.id) as q from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 02 and (tbl_appversion.version not like '(not set)')";
$result13=mysqli_query($conn,$query13);
if($result13)
{
    while($row=mysqli_fetch_assoc($result13))
    {
        $fevereiro = $row['q'];
    }     
}
//MARÇO
$query14="select count(tbl_crashreport.id) as r from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 03 and (tbl_appversion.version not like '(not set)')";
$result14=mysqli_query($conn,$query14);
if($result14)
{
    while($row=mysqli_fetch_assoc($result14))
    {
        $marco = $row['r'];
    }     
}
//ABRIL
$query15="select count(tbl_crashreport.id) as s from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 04 and (tbl_appversion.version not like '(not set)')";
$result15=mysqli_query($conn,$query15);
if($result15)
{
    while($row=mysqli_fetch_assoc($result15))
    {
        $abril = $row['s'];
    }     
}
//MAIO
$query16="select count(tbl_crashreport.id) as t from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 05 and (tbl_appversion.version not like '(not set)')";
$result16=mysqli_query($conn,$query16);
if($result16)
{
    while($row=mysqli_fetch_assoc($result16))
    {
        $maio = $row['t'];
    }     
}
//JUNHO
$query17="select count(tbl_crashreport.id) as u from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 06 and (tbl_appversion.version not like '(not set)')";
$result17=mysqli_query($conn,$query17);
if($result17)
{
    while($row=mysqli_fetch_assoc($result17))
    {
        $junho = $row['u'];
    }     
}
//JULHO
$query18="select count(tbl_crashreport.id) as v from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 07 and (tbl_appversion.version not like '(not set)')";
$result18=mysqli_query($conn,$query18);
if($result18)
{
    while($row=mysqli_fetch_assoc($result18))
    {
        $julho = $row['v'];
    }     
}
//AGOSTO
$query19="select count(tbl_crashreport.id) as x from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 08 and (tbl_appversion.version not like '(not set)')";
$result19=mysqli_query($conn,$query19);
if($result19)
{
    while($row=mysqli_fetch_assoc($result19))
    {
        $agosto = $row['x'];
    }     
}
//SETEMBRO
$query20="select count(tbl_crashreport.id) as y from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 09 and (tbl_appversion.version not like '(not set)')";
$result20=mysqli_query($conn,$query20);
if($result20)
{
    while($row=mysqli_fetch_assoc($result20))
    {
        $setembro = $row['y'];
    }     
}
//OUTUBRO
$query21="select count(tbl_crashreport.id) as aa from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 10 and (tbl_appversion.version not like '(not set)')";
$result21=mysqli_query($conn,$query21);
if($result21)
{
    while($row=mysqli_fetch_assoc($result21))
    {
        $outubro = $row['aa'];
    }     
}
//NOVEMBRO
$query22="select count(tbl_crashreport.id) as ab from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 11 and (tbl_appversion.version not like '(not set)')";
$result22=mysqli_query($conn,$query22);
if($result22)
{
    while($row=mysqli_fetch_assoc($result22))
    {
        $novembro = $row['ab'];
    }     
}
//DEZEMBRO
$query23="select count(tbl_crashreport.id) as ac from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 12 and (tbl_appversion.version not like '(not set)')";
$result23=mysqli_query($conn,$query23);
if($result23)
{
    while($row=mysqli_fetch_assoc($result23))
    {
        $dezembro = $row['ac'];
    }     
}
//CONSULTAS QIBUILDER----------------------------------------------------------------------
//JANEIRO
$query24="select count(tbl_crashreport.id) as ad from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 01 and (tbl_appversion.version not like '(not set)')";
$result24=mysqli_query($conn,$query24);
if($result24)
{
    while($row=mysqli_fetch_assoc($result24))
    {
        $janeiroqi = $row['ad'];
    }     
}
//FEVEREIRO
$query25="select count(tbl_crashreport.id) as ae from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 02 and (tbl_appversion.version not like '(not set)')";
$result25=mysqli_query($conn,$query25);
if($result25)
{
    while($row=mysqli_fetch_assoc($result25))
    {
        $fevereiroqi = $row['ae'];
    }     
}
//MARÇO
$query26="select count(tbl_crashreport.id) as af from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 03 and (tbl_appversion.version not like '(not set)')";
$result26=mysqli_query($conn,$query26);
if($result26)
{
    while($row=mysqli_fetch_assoc($result26))
    {
        $marcoqi = $row['af'];
    }     
}
//ABRIL
$query27="select count(tbl_crashreport.id) as ag from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 04 and (tbl_appversion.version not like '(not set)')";
$result27=mysqli_query($conn,$query27);
if($result27)
{
    while($row=mysqli_fetch_assoc($result27))
    {
        $abrilqi = $row['ag'];
    }     
}
//MAIO
$query28="select count(tbl_crashreport.id) as ah from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 05 and (tbl_appversion.version not like '(not set)')";
$result28=mysqli_query($conn,$query28);
if($result28)
{
    while($row=mysqli_fetch_assoc($result28))
    {
        $maioqi = $row['ah'];
    }     
}
//JUNHO
$query29="select count(tbl_crashreport.id) as ai from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 06 and (tbl_appversion.version not like '(not set)')";
$result29=mysqli_query($conn,$query29);
if($result29)
{
    while($row=mysqli_fetch_assoc($result29))
    {
        $junhoqi = $row['ai'];
    }     
}
//JULHO
$query30="select count(tbl_crashreport.id) as aj from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 07 and (tbl_appversion.version not like '(not set)')";
$result30=mysqli_query($conn,$query30);
if($result30)
{
    while($row=mysqli_fetch_assoc($result30))
    {
        $julhoqi = $row['aj'];
    }     
}
//AGOSTO
$query31="select count(tbl_crashreport.id) as ak from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 08 and (tbl_appversion.version not like '(not set)')";
$result31=mysqli_query($conn,$query31);
if($result31)
{
    while($row=mysqli_fetch_assoc($result31))
    {
        $agostoqi = $row['ak'];
    }     
}
//SETEMBRO
$query32="select count(tbl_crashreport.id) as al from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 09 and (tbl_appversion.version not like '(not set)')";
$result32=mysqli_query($conn,$query32);
if($result32)
{
    while($row=mysqli_fetch_assoc($result32))
    {
        $setembroqi = $row['al'];
    }     
}
//OUTUBRO
$query33="select count(tbl_crashreport.id) as am from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 10 and (tbl_appversion.version not like '(not set)')";
$result33=mysqli_query($conn,$query33);
if($result33)
{
    while($row=mysqli_fetch_assoc($result33))
    {
        $outubroqi = $row['am'];
    }     
}
//NOVEMBRO
$query34="select count(tbl_crashreport.id) as an from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 11 and (tbl_appversion.version not like '(not set)')";
$result34=mysqli_query($conn,$query34);
if($result34)
{
    while($row=mysqli_fetch_assoc($result34))
    {
        $novembroqi = $row['an'];
    }     
}
//DEZEMBRO
$query35="select count(tbl_crashreport.id) as ao from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =2 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 12 and (tbl_appversion.version not like '(not set)')";
$result35=mysqli_query($conn,$query35);
if($result35)
{
    while($row=mysqli_fetch_assoc($result35))
    {
        $dezembroqi = $row['ao'];
    }     
}
//CONSULTAS QICAD----------------------------------------------------------------------
//JANEIRO
$query36="select count(tbl_crashreport.id) as ap from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 01 and (tbl_appversion.version not like '(not set)')";
$result36=mysqli_query($conn,$query36);
if($result36)
{
    while($row=mysqli_fetch_assoc($result36))
    {
        $janeirocad = $row['ap'];
    }     
}
//FEVEREIRO
$query37="select count(tbl_crashreport.id) as aq from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 02 and (tbl_appversion.version not like '(not set)')";
$result37=mysqli_query($conn,$query37);
if($result37)
{
    while($row=mysqli_fetch_assoc($result37))
    {
        $fevereirocad = $row['aq'];
    }     
}
//MARÇO
$query38="select count(tbl_crashreport.id) as ar from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 03 and (tbl_appversion.version not like '(not set)')";
$result38=mysqli_query($conn,$query38);
if($result38)
{
    while($row=mysqli_fetch_assoc($result38))
    {
        $marcocad = $row['ar'];
    }     
}
//ABRIL
$query39="select count(tbl_crashreport.id) as aqq from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 04 and (tbl_appversion.version not like '(not set)')";
$result39=mysqli_query($conn,$query39);
if($result39)
{
    while($row=mysqli_fetch_assoc($result39))
    {
        $abrilcad = $row['aqq'];
    }     
}
//MAIO
$query40="select count(tbl_crashreport.id) as at from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 05 and (tbl_appversion.version not like '(not set)')";
$result40=mysqli_query($conn,$query40);
if($result40)
{
    while($row=mysqli_fetch_assoc($result40))
    {
        $maiocad = $row['at'];
    }     
}
//JUNHO
$query41="select count(tbl_crashreport.id) as au from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 06 and (tbl_appversion.version not like '(not set)')";
$result41=mysqli_query($conn,$query41);
if($result41)
{
    while($row=mysqli_fetch_assoc($result41))
    {
        $junhocad = $row['au'];
    }     
}
//JULHO
$query42="select count(tbl_crashreport.id) as av from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 07 and (tbl_appversion.version not like '(not set)')";
$result42=mysqli_query($conn,$query42);
if($result42)
{
    while($row=mysqli_fetch_assoc($result42))
    {
        $julhocad = $row['av'];
    }     
}
//AGOSTO
$query43="select count(tbl_crashreport.id) as ax from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 08 and (tbl_appversion.version not like '(not set)')";
$result43=mysqli_query($conn,$query43);
if($result43)
{
    while($row=mysqli_fetch_assoc($result43))
    {
        $agostocad = $row['ax'];
    }     
}
//SETEMBRO
$query44="select count(tbl_crashreport.id) as ay from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 09 and (tbl_appversion.version not like '(not set)')";
$result44=mysqli_query($conn,$query44);
if($result44)
{
    while($row=mysqli_fetch_assoc($result44))
    {
        $setembrocad = $row['ay'];
    }     
}
//OUTUBRO
$query45="select count(tbl_crashreport.id) as aaa from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 10 and (tbl_appversion.version not like '(not set)')";
$result45=mysqli_query($conn,$query45);
if($result45)
{
    while($row=mysqli_fetch_assoc($result45))
    {
        $outubrocad = $row['aaa'];
    }     
}
//NOVEMBRO
$query46="select count(tbl_crashreport.id) as aab from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 11 and (tbl_appversion.version not like '(not set)')";
$result46=mysqli_query($conn,$query46);
if($result46)
{
    while($row=mysqli_fetch_assoc($result46))
    {
        $novembrocad = $row['aab'];
    }     
}
//DEZEMBRO
$query47="select count(tbl_crashreport.id) as aac from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =4 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = '$anoselecionado' and month(FROM_UNIXTIME(date_created)) = 12 and (tbl_appversion.version not like '(not set)')";
$result47=mysqli_query($conn,$query47);
if($result47)
{
    while($row=mysqli_fetch_assoc($result47))
    {
        $dezembrocad = $row['aac'];
    }     
}
//create array variable
$values = [];

//pushing some variables to the array so we can output something in this example.
array_push($values, array("mes" => "JAN", "newbalance" => $janeiro, "newbalance2" => $janeiroqi, "newbalance3" => $janeirocad));
array_push($values, array("mes" => "FEV", "newbalance" => $fevereiro, "newbalance2" => $fevereiroqi, "newbalance3" => $fevereirocad));
array_push($values, array("mes" => "MAR", "newbalance" => $marco, "newbalance2" => $marcoqi, "newbalance3" => $marcocad));
array_push($values, array("mes" => "ABR", "newbalance" => $abril, "newbalance2" => $abrilqi, "newbalance3" => $abrilcad));
array_push($values, array("mes" => "MAI", "newbalance" => $maio, "newbalance2" => $maioqi, "newbalance3" => $maiocad));
array_push($values, array("mes" => "JUN", "newbalance" => $junho, "newbalance2" => $junhoqi, "newbalance3" => $junhocad));
array_push($values, array("mes" => "JUL", "newbalance" => $julho, "newbalance2" => $julhoqi, "newbalance3" => $julhocad));
array_push($values, array("mes" => "AGO", "newbalance" => $agosto, "newbalance2" => $agostoqi, "newbalance3" => $agostocad));
array_push($values, array("mes" => "SET", "newbalance" => $setembro, "newbalance2" => $setembroqi, "newbalance3" => $setembrocad));
array_push($values, array("mes" => "OUT", "newbalance" => $outubro, "newbalance2" => $outubroqi, "newbalance3" => $outubrocad));
array_push($values, array("mes" => "NOV", "newbalance" => $novembro, "newbalance2" => $novembroqi, "newbalance3" => $novembrocad));
array_push($values, array("mes" => "DEZ", "newbalance" => $dezembro, "newbalance2" => $dezembroqi, "newbalance3" => $dezembrocad));


/*

    //pushing some variables to the array so we can output something in this example.
array_push($values, array("mes" => "JAN", "newbalance" => $janeiro, "newbalance2" => $janeiroqi, "newbalance3" => $janeirocad));
array_push($values, array("mes" => "FEV", "newbalance" => $fevereiro, "newbalance2" => $fevereiroqi, "newbalance3" => $fevereirocad));
array_push($values, array("mes" => "MAR", "newbalance" => $marco, "newbalance2" => $marcoqi, "newbalance3" => $marcocad));
array_push($values, array("mes" => "ABR", "newbalance" => $abril, "newbalance2" => $abrilqi, "newbalance3" => $abrilcad));
array_push($values, array("mes" => "MAI", "newbalance" => $maio, "newbalance2" => $maioqi, "newbalance3" => $maiocad));
array_push($values, array("mes" => "JUN", "newbalance" => $junho, "newbalance2" => $junhoqi, "newbalance3" => $junhocad));
array_push($values, array("mes" => "JUL", "newbalance" => $julho, "newbalance2" => $julhoqi, "newbalance3" => $julhocad));
array_push($values, array("mes" => "AGO", "newbalance" => $agosto, "newbalance2" => $agostoqi, "newbalance3" => $agostocad));
array_push($values, array("mes" => "SET", "newbalance" => $setembro, "newbalance2" => $setembroqi, "newbalance3" => $setembrocad));
array_push($values, array("mes" => "OUT", "newbalance" => $outubro, "newbalance2" => $outubroqi, "newbalance3" => $outubrocad));
array_push($values, array("mes" => "NOV", "newbalance" => $novembro, "newbalance2" => $novembroqi, "newbalance3" => $novembrocad));
array_push($values, array("mes" => "DEZ", "newbalance" => $dezembro, "newbalance2" => $dezembroqi, "newbalance3" => $dezembrocad));
*/

//counting the length of the array
$countArrayLength = count($values);

?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load("visualization", "1", {packages:["corechart"]});
    google.setOnLoadCallback(drawChart);

    function drawChart() {

        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Mes');
        data.addColumn('number', 'Eberick');
        data.addColumn('number', 'QiBuilder');
        data.addColumn('number', 'QiCad');

        data.addRows([

            <?php
            for($i=0;$i<$countArrayLength;$i++){
                echo "['" . $values[$i]['mes'] . "'," . $values[$i]['newbalance'] . "," . $values[$i]['newbalance2'] . "," . $values[$i]['newbalance3'] . "],";
            }
            ?>
        ]);

        var options = {
            title: 'Crashes mês a mês',
            curveType: 'function',
            legend: { position: 'bottom' }, 
            colors: ['#335E52', '#2CA871', '#6FEDC0']
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));
        chart.draw(data, options);
    }
</script>

<div class="grid-container"> 
    <div class="grid-100 grid-parent">
        <div id="curve_chart" style="width: 100%; height: auto"></div>
    </div>   

</div>



<?php

//PRECISO CONSIDERAR O ANO AQUI NESSA QUERY MAS AINDA NAO FIZ 
$result9 = $conn->query("select * from tbl_appversion where project_id = 4 and (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and (tbl_appversion.version not like '(not set)') order by id");
$id9[0] = 0;
$versao9[0] = 0;
$i=0;
while (($row = $result9->fetch_assoc())) {
    $idi[$i] =  $row['id'];
    $versao9[$i] = $row['version'];
    $i++;
}
//print_r($versao9);



?>



<?php

$i =0;
$max = sizeof($versao9);

//GRÁFICOS DE CRASHES POR ANO E VERSÃO

//JANEIRO 
for($i =0; $i < $max; $i++){
    $qAreaJAN = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 1 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaJAN=mysqli_query($conn, $qAreaJAN);
    if($qAreaJAN)
    {
        while($row=mysqli_fetch_assoc($qAreaJAN))
        {
            $areaJAN[$i] = $row['k'];
        }     
    }
}
//FEVEREIRO
for($i = 0; $i < $max; $i++){
    $qAreaFEV = "SELECT count(*) as R FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 2 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaFEV=mysqli_query($conn, $qAreaFEV);
    if($qAreaFEV)
    {
        while($row=mysqli_fetch_assoc($qAreaFEV))
        {
            $areaFEV[$i] = $row['R'];
        }     
    }
}
//MARCO
for($i = 0; $i < $max; $i++){
    $qAreaMAR = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 3 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaMAR=mysqli_query($conn, $qAreaMAR);
    if($qAreaMAR)
    {
        while($row=mysqli_fetch_assoc($qAreaMAR))
        {
            $areaMAR[$i] = $row['k'];
        }     
    }
}
//ABRIL
for($i = 0; $i < $max; $i++){
    $qAreaABR = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 4 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaABR=mysqli_query($conn, $qAreaABR);
    if($qAreaABR)
    {
        while($row=mysqli_fetch_assoc($qAreaABR))
        {
            $areaABR[$i] = $row['k'];
        }     
    }
}
//MAIO
for($i = 0; $i < $max; $i++){
    $qAreaMAI = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 5 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaMAI=mysqli_query($conn, $qAreaMAI);
    if($qAreaMAI)
    {
        while($row=mysqli_fetch_assoc($qAreaMAI))
        {
            $areaMAI[$i] = $row['k'];
        }     
    }
}
//JUNHO
for($i = 0; $i < $max; $i++){
    $qAreaJUN = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 6 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaJUN=mysqli_query($conn, $qAreaJUN);
    if($qAreaJUN)
    {
        while($row=mysqli_fetch_assoc($qAreaJUN))
        {
            $areaJUN[$i] = $row['k'];
        }     
    }
}
//JULHO
for($i = 0; $i < $max; $i++){
    $qAreaJUL = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 7 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaJUL=mysqli_query($conn, $qAreaJUL);
    if($qAreaJUL)
    {
        while($row=mysqli_fetch_assoc($qAreaJUL))
        {
            $areaJUL[$i] = $row['k'];
        }     
    }
}
//AGOSTO
for($i = 0; $i < $max; $i++){
    $qAreaAGO = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 8 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaAGO=mysqli_query($conn, $qAreaAGO);
    if($qAreaAGO)
    {
        while($row=mysqli_fetch_assoc($qAreaAGO))
        {
            $areaAGO[$i] = $row['k'];
        }     
    }
}

//SETEMBRO
for($i = 0; $i < $max; $i++){
    $qAreaSET = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 9 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaSET=mysqli_query($conn, $qAreaSET);
    if($qAreaSET)
    {
        while($row=mysqli_fetch_assoc($qAreaSET))
        {
            $areaSET[$i] = $row['k'];
        }     
    }
}
//OUTUBRO
for($i = 0; $i < $max; $i++){
    $qAreaOUT = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 10 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaOUT=mysqli_query($conn, $qAreaOUT);
    if($qAreaOUT)
    {
        while($row=mysqli_fetch_assoc($qAreaOUT))
        {
            $areaOUT[$i] = $row['k'];
        }     
    }
}
//NOVEMBRO
for($i = 0; $i < $max; $i++){
    $qAreaNOV = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 11 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaNOV=mysqli_query($conn, $qAreaNOV);
    if($qAreaNOV)
    {
        while($row=mysqli_fetch_assoc($qAreaNOV))
        {
            $areaNOV[$i] = $row['k'];
        }     
    }
}

//DEZEMBRO
for($i = 0; $i < $max; $i++){
    $qAreaDEZ = "SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 12 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && appversion_id = '$idi[$i]' && project_id = 4";
    $qAreaDEZ=mysqli_query($conn, $qAreaDEZ);
    if($qAreaDEZ)
    {
        while($row=mysqli_fetch_assoc($qAreaDEZ))
        {
            $areaDEZ[$i] = $row['k'];
        }     
    }
}

?>


<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([

            <?php
            $max = sizeof($versao9);
            echo "['MES',";            
            for($i = 0; $i < $max;$i++)
            {
                echo "'" . $versao9[$i] . "',";
            }
            echo "],";
            ?>
         
            ['JAN',    <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaJAN[$i] . ",";
            }
            echo "],";
            ?>
          
            ['FEV',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaFEV[$i] . ",";
            }
            echo "],";
            ?>
            ['MAR',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaMAR[$i] . ",";
            }
            echo "],";
            ?>
            ['ABR', <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaABR[$i] . ",";
            }
            echo "],";
            ?>
            ['MAI', <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaMAI[$i] . ",";
            }
            echo "],";
            ?>
            ['JUN', <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaJUN[$i] . ",";
            }
            echo "],";
            ?>
            ['JUL',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaJUL[$i] . ",";
            }
            echo "],";
            ?>
            ['AGO',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaAGO[$i] . ",";
            }
            echo "],";
            ?>
            ['SET',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaSET[$i] . ",";
            }
            echo "],";
            ?>
            ['OUT',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaOUT[$i] . ",";
            }
            echo "],";
            ?>
            ['NOV', <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaNOV[$i] . ",";
            }
            echo "],";
            ?>
            ['DEZ',  <?php
            $max = sizeof($versao9);      
            for($i = 0; $i < $max;$i++)
            {
                echo $areaDEZ[$i] . ",";
            }
            echo "],";
            ?>
        ]);

        var options = {
            title: 'Qicad - Número de crashes por mês, ano e versão',
            hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
            vAxis: {minValue: 0}
        };
        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    }
</script>
<div id="chart_div" style="width: 100%; height: 500px;"></div>
</body>
</html>

<?php
 /* ANOTACAO IMPORTANTES 
$max = sizeof($versao9);
echo "[";            
for($i = 0; $i < $max;$i++)
{
    echo "'" . $idi[$i] . "',";
}
echo "],";



 query que deu certo 
select * from tbl_appversion where (version not like '%DEV' AND version not like '%RC'  AND version not like 'null') and project_id =1  and (version not like '(not set)') order by id

SELECT  tbl_appversion.project_id ,version, appversion_id  FROM crashfix.tbl_crashreport, crashfix.tbl_appversion  


//conta os crashes sem os internos 

select count(tbl_crashreport.id) from tbl_crashreport left join tbl_appversion on tbl_appversion.id = tbl_crashreport.appversion_id  where (tbl_appversion.version not like '%DEV' AND tbl_appversion.version not like '%RC'  AND tbl_appversion.version not like 'null') and tbl_crashreport.project_id =1 and  year(FROM_UNIXTIME(tbl_crashreport.date_created)) = 2018 and  month(FROM_UNIXTIME(tbl_crashreport.date_created)) = 01 and (tbl_appversion.version not like '(not set)')


*/
?>
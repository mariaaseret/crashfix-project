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

//PARA O GRÁFICO DE PIZZA TOTAL
$query1="SELECT count(id) AS a FROM crashfix.tbl_crashreport WHERE project_id = 1";
$result1=mysqli_query($conn,$query1);
if($result1)
{
    while($row=mysqli_fetch_assoc($result1))
    {
        $a = $row['a'];
    }     
}


$query2="SELECT count(id) AS b FROM crashfix.tbl_crashreport WHERE project_id = 2";
$result2=mysqli_query($conn,$query2);
if($result2)
{
    while($row=mysqli_fetch_assoc($result2))
    {
        $b = $row['b'];

    }     
}


$query3='SELECT count(id) AS c FROM crashfix.tbl_crashreport WHERE project_id = 4';
$result3=mysqli_query($conn,$query3);
if($result3)
{
    while($row=mysqli_fetch_assoc($result3))
    {
        $c = $row['c'];
    }     
}
$soma = $a + $b + $c;
$porcentagema = (100*$a)/$soma;
$porcentagemb = (100*$b)/$soma;
$porcentagemc = (100*$c)/$soma;




//PARA O GRÁFICO MENSAL


$anoselecionado = 2018;
$messelecionado = 01;
$anoselecionado2 = 2018;
$messelecionado2 = 01;




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Trasitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="txt/html; charset=utf-8" />
        <title>Gráficos e Relatórios Crashfix</title>
        <link rel="shortcut icon" href="https://www.altoqi.com.br/wp-content/uploads/2017/10/cropped-favicon-01.png" type="image/x-icon" 

              <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


    <script type="text/javascript">
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            // Define the chart to be drawn.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Element');
            data.addColumn('number', 'Percentage');
            data.addRows([
                ['Eberick: <?php echo $a?>', <?php echo $porcentagema?>],
                ['Qibuilder: <?php echo $b?>',  <?php echo $porcentagemb?>],
                ['Qicad: <?php echo $c?>',  <?php echo $porcentagemc?>]
            ]);


            var options = {
                colors: ['#335E52', '#2CA871', '#6FEDC0'],
                title: 'Número total de crashes por Projeto ',
                is3D: true,
            };

            // Instantiate and draw the chart.
            var chart = new google.visualization.PieChart(document.getElementById('myPieChart'));
            chart.draw(data, options);
        }
    </script>


    </head>



<body>
    <table class="columns">
        <tr>
            <td>
                <p style="font-family: 'Lato', Helvetica, Arial, sans-serif; "><b>Número total de crashes por mês e ano</b></p>

                <form  method="post">
                    <select name="SelecaoMes">
                        <option value="00">Mês</option>
                        <option value="01">Janeiro</option>
                        <option value="02">Fevereiro</option>
                        <option value="03">Março</option>
                        <option value="04">Abril</option>
                        <option value="05">Maio</option>
                        <option value="06">Junho</option>
                        <option value="07">Julho</option>
                        <option value="08">Agosto</option>
                        <option value="09">Setembro</option>
                        <option value="10">Outubro</option>
                        <option value="11">Novembro</option>
                        <option value="12">Dezembro</option>
                    </select>
                    <select name="SelecaoAno">
                        <option value="selecione">Ano</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                    </select>
                    <input type="submit" name="submit" value="Selecionar"/>
                </form>

                <?php

    if(isset($_POST['submit'])) {
        $anoselecionado = $_POST['SelecaoAno'];
        $messelecionado = $_POST['SelecaoMes'];  }// VARIAVEL SELECIONADA


                 //PARA O GRÁFICO MENSAL
                 $query4="SELECT count(id) as d FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado'";
                 $result4=mysqli_query($conn,$query4);
                 $query5="SELECT count(id) as e FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' &&  project_id = 1";
                 $result5=mysqli_query($conn,$query5);
                 $query6="SELECT count(id) as f FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' &&  project_id = 2";
                 $result6=mysqli_query($conn,$query6);
                 $query7="SELECT count(id) as g FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' &&  project_id = 4";
                 $result7=mysqli_query($conn,$query7);


                ?>

                <table>

                    <tr>

                        <?php

                        if($result4)
                        {
                            while($row=mysqli_fetch_assoc($result4))
                            {
                                echo '<td>';
                                echo "Mês selecionado: ";
                                echo '</td>';
                                echo '<td>';
                                echo $messelecionado;
                                echo '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td>';
                                echo "Ano selecionado: ";
                                echo '</td>';
                                echo '<td>';
                                echo $anoselecionado;
                                echo '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td>';
                                echo 'Total de crashes: ';
                                echo '</td>';
                                echo '<td>';
                                echo $row['d'];
                                echo '</td>';
                                echo '</tr>';

                            }     
                        }
                        $eberick = 1 ;
                        $qibuilder = 1 ;
                        $qicad = 1 ;

                        if($result5)
                        {
                            while($row=mysqli_fetch_assoc($result5))
                            {
                                echo '<tr>';
                                echo '<td>';
                                echo 'Crashes do Eberick: ';
                                echo '</td>';
                                echo '<td>';
                                $eberick = $row['e'];
                                echo $row['e'];
                                echo '</td>';
                                echo '</tr>';

                            }     
                        }
                        if($result6)
                        {
                            while($row=mysqli_fetch_assoc($result6))
                            {
                                echo '<tr>';
                                echo '<td>';
                                echo 'Crashes do QiBuilder: ';
                                echo '</td>';
                                echo '<td>';
                                $qibuilder = $row['f'];
                                echo $row['f'];
                                echo '</td>';
                                echo '</tr>';
                            }     
                        }
                        if($result7)
                        {
                            while($row=mysqli_fetch_assoc($result7))
                            {
                                echo '<tr>';
                                echo '<td>';
                                echo 'Crashes do QiCad: ';
                                echo '</td>';
                                echo '<td>';
                                $qicad = $row['g'];
                                echo $row['g'];
                                echo '</td>';
                                echo '</tr>';
                                echo '</table>';
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
                                    title: 'Número mensal de crashes por Projeto',
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

            <td><div id="myPieChart" style="border: 1px;   height: 200px; width: 500px;"></div></td>
        </tr>

    </table>


    <?php 

    //CONSULTAS EBERICK----------------------------------------------------------------------
    //JANEIRO
    $query12="SELECT count(*) as p FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 01 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result12=mysqli_query($conn,$query12);


    if($result12)
    {
        while($row=mysqli_fetch_assoc($result12))
        {
            $janeiro = $row['p'];
        }     
    }

    //FEVEREIRO
    $query13="SELECT count(*) as q FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 02 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result13=mysqli_query($conn,$query13);


    if($result13)
    {
        while($row=mysqli_fetch_assoc($result13))
        {
            $fevereiro = $row['q'];
        }     
    }


    //MARÇO
    $query14="SELECT count(*) as r FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 03 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result14=mysqli_query($conn,$query14);


    if($result14)
    {
        while($row=mysqli_fetch_assoc($result14))
        {
            $marco = $row['r'];
        }     
    }


    //ABRIL
    $query15="SELECT count(*) as s FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 04 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result15=mysqli_query($conn,$query15);


    if($result15)
    {
        while($row=mysqli_fetch_assoc($result15))
        {
            $abril = $row['s'];
        }     
    }


    //MAIO
    $query16="SELECT count(*) as t FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 05 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result16=mysqli_query($conn,$query16);


    if($result16)
    {
        while($row=mysqli_fetch_assoc($result16))
        {
            $maio = $row['t'];
        }     
    }



    //JUNHO
    $query17="SELECT count(*) as u FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 06 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result17=mysqli_query($conn,$query17);


    if($result17)
    {
        while($row=mysqli_fetch_assoc($result17))
        {
            $junho = $row['u'];
        }     
    }


    //JULHO
    $query18="SELECT count(*) as v FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 07 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result18=mysqli_query($conn,$query18);


    if($result18)
    {
        while($row=mysqli_fetch_assoc($result18))
        {
            $julho = $row['v'];
        }     
    }




    //AGOSTO
    $query19="SELECT count(*) as x FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 08 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result19=mysqli_query($conn,$query19);


    if($result19)
    {
        while($row=mysqli_fetch_assoc($result19))
        {
            $agosto = $row['x'];
        }     
    }



    //SETEMBRO
    $query20="SELECT count(*) as y FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 09 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result20=mysqli_query($conn,$query20);


    if($result20)
    {
        while($row=mysqli_fetch_assoc($result20))
        {
            $setembro = $row['y'];
        }     
    }




    //OUTUBRO
    $query21="SELECT count(*) as aa FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 10 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result21=mysqli_query($conn,$query21);


    if($result21)
    {
        while($row=mysqli_fetch_assoc($result21))
        {
            $outubro = $row['aa'];
        }     
    }



    //NOVEMBRO
    $query22="SELECT count(*) as ab FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 11 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
    $result22=mysqli_query($conn,$query22);


    if($result22)
    {
        while($row=mysqli_fetch_assoc($result22))
        {
            $novembro = $row['ab'];
        }     
    }



    //DEZEMBRO
    $query23="SELECT count(*) as ac FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 12 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 1";
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
    $query24="SELECT count(*) as ad FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 01 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result24=mysqli_query($conn,$query24);


    if($result24)
    {
        while($row=mysqli_fetch_assoc($result24))
        {
            $janeiroqi = $row['ad'];
        }     
    }

    //FEVEREIRO
    $query25="SELECT count(*) as ae FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 02 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result25=mysqli_query($conn,$query25);


    if($result25)
    {
        while($row=mysqli_fetch_assoc($result25))
        {
            $fevereiroqi = $row['ae'];
        }     
    }


    //MARÇO
    $query26="SELECT count(*) as af FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 03 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result26=mysqli_query($conn,$query26);


    if($result26)
    {
        while($row=mysqli_fetch_assoc($result26))
        {
            $marcoqi = $row['af'];
        }     
    }


    //ABRIL
    $query27="SELECT count(*) as ag FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 04 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result27=mysqli_query($conn,$query27);


    if($result27)
    {
        while($row=mysqli_fetch_assoc($result27))
        {
            $abrilqi = $row['ag'];
        }     
    }


    //MAIO
    $query28="SELECT count(*) as ah FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 05 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result28=mysqli_query($conn,$query28);


    if($result28)
    {
        while($row=mysqli_fetch_assoc($result28))
        {
            $maioqi = $row['ah'];
        }     
    }



    //JUNHO
    $query29="SELECT count(*) as ai FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 06 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result29=mysqli_query($conn,$query29);


    if($result29)
    {
        while($row=mysqli_fetch_assoc($result29))
        {
            $junhoqi = $row['ai'];
        }     
    }


    //JULHO
    $query30="SELECT count(*) as aj FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 07 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result30=mysqli_query($conn,$query30);


    if($result30)
    {
        while($row=mysqli_fetch_assoc($result30))
        {
            $julhoqi = $row['aj'];
        }     
    }




    //AGOSTO
    $query31="SELECT count(*) as ak FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 08 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result31=mysqli_query($conn,$query31);


    if($result31)
    {
        while($row=mysqli_fetch_assoc($result31))
        {
            $agostoqi = $row['ak'];
        }     
    }



    //SETEMBRO
    $query32="SELECT count(*) as al FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 09 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result32=mysqli_query($conn,$query32);


    if($result32)
    {
        while($row=mysqli_fetch_assoc($result32))
        {
            $setembroqi = $row['al'];
        }     
    }




    //OUTUBRO
    $query33="SELECT count(*) as am FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 10 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result33=mysqli_query($conn,$query33);


    if($result33)
    {
        while($row=mysqli_fetch_assoc($result33))
        {
            $outubroqi = $row['am'];
        }     
    }



    //NOVEMBRO
    $query34="SELECT count(*) as an FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 11 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
    $result34=mysqli_query($conn,$query34);


    if($result34)
    {
        while($row=mysqli_fetch_assoc($result34))
        {
            $novembroqi = $row['an'];
        }     
    }



    //DEZEMBRO
    $query35="SELECT count(*) as ao FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 12 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 2";
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
    $query36="SELECT count(*) as ap FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 01 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result36=mysqli_query($conn,$query36);


    if($result36)
    {
        while($row=mysqli_fetch_assoc($result36))
        {
            $janeirocad = $row['ap'];
        }     
    }


    //FEVEREIRO
    $query37="SELECT count(*) as aq FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 02 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result37=mysqli_query($conn,$query37);


    if($result37)
    {
        while($row=mysqli_fetch_assoc($result37))
        {
            $fevereirocad = $row['aq'];
        }     
    }


    //MARÇO
    $query38="SELECT count(*) as ar FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 03 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result38=mysqli_query($conn,$query38);


    if($result38)
    {
        while($row=mysqli_fetch_assoc($result38))
        {
            $marcocad = $row['ar'];
        }     
    }


    
    //ABRIL
    $query39="SELECT count(*) as aqq FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 04 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result39=mysqli_query($conn,$query39);


    if($result39)
    {
        while($row=mysqli_fetch_assoc($result39))
        {
            $abrilcad = $row['aqq'];
        }     
    }

    
    
    //MAIO
    $query40="SELECT count(*) as at FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 05 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result40=mysqli_query($conn,$query40);


    if($result40)
    {
        while($row=mysqli_fetch_assoc($result40))
        {
            $maiocad = $row['at'];
        }     
    }



    //JUNHO
    $query41="SELECT count(*) as au FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 06 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result41=mysqli_query($conn,$query41);


    if($result41)
    {
        while($row=mysqli_fetch_assoc($result41))
        {
            $junhocad = $row['au'];
        }     
    }


    //JULHO
    $query42="SELECT count(*) as av FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 07 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result42=mysqli_query($conn,$query42);


    if($result42)
    {
        while($row=mysqli_fetch_assoc($result42))
        {
            $julhocad = $row['av'];
        }     
    }




    //AGOSTO
    $query43="SELECT count(*) as ax FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 08 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result43=mysqli_query($conn,$query43);


    if($result43)
    {
        while($row=mysqli_fetch_assoc($result43))
        {
            $agostocad = $row['ax'];
        }     
    }



    //SETEMBRO
    $query44="SELECT count(*) as ay FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 09 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result44=mysqli_query($conn,$query44);


    if($result44)
    {
        while($row=mysqli_fetch_assoc($result44))
        {
            $setembrocad = $row['ay'];
        }     
    }




    //OUTUBRO
    $query45="SELECT count(*) as aaa FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 10 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result45=mysqli_query($conn,$query45);


    if($result45)
    {
        while($row=mysqli_fetch_assoc($result45))
        {
            $outubrocad = $row['aaa'];
        }     
    }



    //NOVEMBRO
    $query46="SELECT count(*) as aab FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 11 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
    $result46=mysqli_query($conn,$query46);


    if($result46)
    {
        while($row=mysqli_fetch_assoc($result46))
        {
            $novembrocad = $row['aab'];
        }     
    }



    //DEZEMBRO
    $query47="SELECT count(*) as aac FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = 12 && year(FROM_UNIXTIME(date_created)) = '$anoselecionado' && project_id = 4";
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
            title: 'Crashes do ano selecionado',
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

    $result10 = $conn->query("select * from tbl_appversion where project_id = 1 order by id");

    $id10 =0;
    echo "<html>";
    echo "<body>";
    echo "<hr>";
    echo "<p style='font-size:18px; font-family: 'Lato', Helvetica, Arial, sans-serif;'><b>Eberick - Número de crashes por mês, ano e versão</b></p>";
    echo "<form  method='post'>";
    echo "<select name='versao10'>";
    while (($row = $result10->fetch_assoc())) {
        unset($id10);
        $id10 = $row['id'];
        $versao10 = $row['version'];
        echo '<option value="'.$id10.'">'.$versao10.'</option>';
    }
    echo "</select>";

    ?>
    <select name="SelecaoMes10">
        <option value="00">Mês</option>
        <option value="01">Janeiro</option>
        <option value="02">Fevereiro</option>
        <option value="03">Março</option>
        <option value="04">Abril</option>
        <option value="05">Maio</option>
        <option value="06">Junho</option>
        <option value="07">Julho</option>
        <option value="08">Agosto</option>
        <option value="09">Setembro</option>
        <option value="10">Outubro</option>
        <option value="11">Novembro</option>
        <option value="12">Dezembro</option>
    </select>
    <select name="SelecaoAno10">
        <option value="selecione">Ano</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
    </select>


    <input type="submit" name="submit10" value="Selecionar"/>
    </form>

<?php

$messelecionado10 = 01;
$anoselecionado10 = 2017;
$appversion10 = 10;

if(isset($_POST['submit10'])) {
    $anoselecionado10 = $_POST['SelecaoAno10'];
    $messelecionado10 = $_POST['SelecaoMes10'];
    $appversion10 = $_POST['versao10'];   


}

$query10="SELECT count(*) as l FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado10' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado10' && appversion_id = '$appversion10' && project_id = 1";
$result10=mysqli_query($conn,$query10);

?>
<table>
    <tr>
        <?php


        if($result10)
        {
            while($row=mysqli_fetch_assoc($result10))
            {
                echo '<td>';
                echo "Mês selecionado: ";
                echo '</td>';
                echo '<td>';
                echo $messelecionado10;
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo "Ano selecionado: ";
                echo '</td>';
                echo '<td>';
                echo $anoselecionado10;
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'Total de crashes: ';
                echo '</td>';
                echo '<td>';
                echo $row['l'];
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'app version: ';
                echo '</td>';
                echo '<td>';
                echo $appversion10;
                echo '</td>';
                echo '</tr>';
            }     
        }



        ?>
    </tr>



</table>

<hr>

<?php
$result11 = $conn->query("select * from tbl_appversion where project_id = 2 order by id");

$id11 =0;
echo "<html>";
echo "<body>";
echo "<p style='font-size:18px; font-family: 'Lato', Helvetica, Arial, sans-serif;'><b>Qibulder - Número de crashes por mês, ano e versão</b></p>";
echo "<form  method='post'>";
echo "<select name='versao11'>";
while (($row = $result11->fetch_assoc())) {
    unset($id11);
    $id11 = $row['id'];
    $versao11 = $row['version'];
    echo '<option value="'.$id11.'">'.$versao11.'</option>';
}
echo "</select>";

?>
<select name="SelecaoMes11">
    <option value="00">Mês</option>
    <option value="01">Janeiro</option>
    <option value="02">Fevereiro</option>
    <option value="03">Março</option>
    <option value="04">Abril</option>
    <option value="05">Maio</option>
    <option value="06">Junho</option>
    <option value="07">Julho</option>
    <option value="08">Agosto</option>
    <option value="09">Setembro</option>
    <option value="10">Outubro</option>
    <option value="11">Novembro</option>
    <option value="12">Dezembro</option>
</select>
<select name="SelecaoAno11">
    <option value="selecione">Ano</option>
    <option value="2017">2017</option>
    <option value="2018">2018</option>
    <option value="2019">2019</option>
</select>


<input type="submit" name="submit11" value="Selecionar"/>
</form>
<?php

$messelecionado11 = 01;
$anoselecionado11 = 2017;
$appversion11 = 10;

if(isset($_POST['submit11'])) {
    $anoselecionado11 = $_POST['SelecaoAno11'];
    $messelecionado11 = $_POST['SelecaoMes11'];
    $appversion11 = $_POST['versao11'];   


}

$query11="SELECT count(*) as o FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado10' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado10' && appversion_id = '$appversion10' && project_id = 4";
$result11=mysqli_query($conn,$query11);

?>
<table>
    <tr>
        <?php


        if($result11)
        {
            while($row=mysqli_fetch_assoc($result11))
            {
                echo '<td>';
                echo "Mês selecionado: ";
                echo '</td>';
                echo '<td>';
                echo $messelecionado11;
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo "Ano selecionado: ";
                echo '</td>';
                echo '<td>';
                echo $anoselecionado11;
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'Total de crashes: ';
                echo '</td>';
                echo '<td>';
                echo $row['o'];
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'app version: ';
                echo '</td>';
                echo '<td>';
                echo $appversion11;
                echo '</td>';
                echo '</tr>';
            }     
        }



        ?>
    </tr>



</table>


<hr>
<?php

$result9 = $conn->query("select * from tbl_appversion where project_id = 4 order by id");

$id9 =0;
echo "<html>";
echo "<body>";
echo "<p style='font-size:18px; font-family: 'Lato', Helvetica, Arial, sans-serif;'><b>Qicad - Número de crashes por mês, ano e versão</b></p>";
echo "<form  method='post'>";
echo "<select name='versao9'>";
while (($row = $result9->fetch_assoc())) {
    unset($id9);
    $id9 = $row['id'];
    $versao9 = $row['version'];
    echo '<option value="'.$id9.'">'.$versao9.'</option>';
}
echo "</select>";

?>
<select name="SelecaoMes9">
    <option value="00">Mês</option>
    <option value="01">Janeiro</option>
    <option value="02">Fevereiro</option>
    <option value="03">Março</option>
    <option value="04">Abril</option>
    <option value="05">Maio</option>
    <option value="06">Junho</option>
    <option value="07">Julho</option>
    <option value="08">Agosto</option>
    <option value="09">Setembro</option>
    <option value="10">Outubro</option>
    <option value="11">Novembro</option>
    <option value="12">Dezembro</option>
</select>
<select name="SelecaoAno9">
    <option value="selecione">Ano</option>
    <option value="2017">2017</option>
    <option value="2018">2018</option>
    <option value="2019">2019</option>
</select>


<input type="submit" name="submit9" value="Selecionar"/>
</form>
<?php

$messelecionado9 = 01;
$anoselecionado9 = 2017;
$appversion9 = 10;

if(isset($_POST['submit9'])) {
    $anoselecionado9 = $_POST['SelecaoAno9'];
    $messelecionado9 = $_POST['SelecaoMes9'];
    $appversion9 = $_POST['versao9'];   


}

$query9="SELECT count(*) as k FROM crashfix.tbl_crashreport WHERE month(FROM_UNIXTIME(date_created)) = '$messelecionado9' && year(FROM_UNIXTIME(date_created)) = '$anoselecionado9' && appversion_id = '$appversion9' && project_id = 4";
$result9=mysqli_query($conn,$query9);

?>
<table>
    <tr>
        <?php


        if($result9)
        {
            while($row=mysqli_fetch_assoc($result9))
            {
                echo '<td>';
                echo "Mês selecionado: ";
                echo '</td>';
                echo '<td>';
                echo $messelecionado9;
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo "Ano selecionado: ";
                echo '</td>';
                echo '<td>';
                echo $anoselecionado9;
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'Total de crashes: ';
                echo '</td>';
                echo '<td>';
                echo $row['k'];
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>';
                echo 'app version: ';
                echo '</td>';
                echo '<td>';
                echo $appversion9;
                echo '</td>';
                echo '</tr>';
            }     
        }



        ?>
    </tr>




</table>

<hr>




</body>
</html>
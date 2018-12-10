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
    a.button {
        padding:5px 15px; 
        background:#ccc; 
        border:0 none;
        cursor:pointer;
        -webkit-border-radius: 5px;
        border-radius: 5px; 
        text-decoration: none;
        color: initial;
        position: absolute;
        left: 90%;
        top: 61px;

    }

</style>




<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Trasitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <head>
        <meta http-equiv="content-type" content="txt/html; charset=utf-8" />
        <title>Gráficos e Relatórios Crashfix</title>
        <link rel="shortcut icon" href="https://www.altoqi.com.br/wp-content/uploads/2017/10/cropped-favicon-01.png" type="image/x-icon" />
        
    
        <script type="text/javascript">

        </script>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

    </head>


    <body >
        <?php require('queries.php');?>
        <table class="columns">
            <tr>
                <td>
                    <p style="font-family: 'Lato', Helvetica, Arial, sans-serif; "><b>Selecione o ano desejadoss</b></p>

                    <a href="http://devsite1.altoqi.com.br/projeto-crashfix/suporte.php" class="button">Área Suporte</a>

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

<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([

            <?php
            $maxi = sizeof($versao11);
            echo "['MES',";            
            for($i = 0; $i < $maxi;$i++)
            {
                echo "'" . $versao11[$i] . "',";
            }
            echo "],";
            ?>

            ['JAN',    <?php
             for($i = 0; $i < $maxi;$i++)
             {
                 echo $areaJANEberick[$i] . ",";
             }
             echo "],";
             ?>

             ['FEV',  <?php
              for($i = 0; $i < $maxi;$i++)
              {
                  echo $areaFEVEberick[$i] . ",";
              }
              echo "],";
              ?>
              ['MAR',  <?php
               for($i = 0; $i < $maxi;$i++)
               {
                   echo $areaMAREberick[$i] . ",";
               }
               echo "],";
               ?>
               ['ABR', <?php
                for($i = 0; $i < $maxi;$i++)
                {
                    echo $areaABREberick[$i] . ",";
                }
                echo "],";
                ?>
                ['MAI', <?php
                 for($i = 0; $i < $maxi;$i++)
                 {
                     echo $areaMAIEberick[$i] . ",";
                 }
                 echo "],";
                 ?>
                 ['JUN', <?php
                  for($i = 0; $i < $maxi;$i++)
                  {
                      echo $areaJUNEberick[$i] . ",";
                  }
                  echo "],";
                  ?>
                  ['JUL',  <?php
                   for($i = 0; $i < $maxi;$i++)
                   {
                       echo $areaJULEberick[$i] . ",";
                   }
                   echo "],";
                   ?>
                   ['AGO',  <?php
                    for($i = 0; $i < $maxi;$i++)
                    {
                        echo $areaAGOEberick[$i] . ",";
                    }
                    echo "],";
                    ?>
                    ['SET',  <?php
                     for($i = 0; $i < $maxi;$i++)
                     {
                         echo $areaSETEberick[$i] . ",";
                     }
                     echo "],";
                     ?>
                     ['OUT',  <?php
                      for($i = 0; $i < $maxi;$i++)
                      {
                          echo $areaOUTEberick[$i] . ",";
                      }
                      echo "],";
                      ?>
                      ['NOV', <?php
                       for($i = 0; $i < $maxi;$i++)
                       {
                           echo $areaNOVEberick[$i] . ",";
                       }
                       echo "],";
                       ?>
                       ['DEZ',  <?php
                        for($i = 0; $i < $maxi;$i++)
                        {
                            echo $areaDEZEberick[$i] . ",";
                        }
                        echo "],";
                        ?>
                       ]);

                       var options = {
                       title: 'Eberick - Número de crashes por mês, ano e versão',
                       hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
                       vAxis: {minValue: 0}
                       };
                       var chart = new google.visualization.AreaChart(document.getElementById('chart_div3'));
                       chart.draw(data, options);
                       }
</script>
<div id="chart_div3" style="width: 100%; height: 500px;"></div>


<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([

            <?php
            $maxa = sizeof($versao10);
            echo "['MES',";            
            for($i = 0; $i < $maxa;$i++)
            {
                echo "'" . $versao10[$i] . "',";
            }
            echo "],";
            ?>

            ['JAN',    <?php
             for($i = 0; $i < $maxa;$i++)
             {
                 echo $areaJANQibuilder[$i] . ",";
             }
             echo "],";
             ?>

             ['FEV',  <?php
              for($i = 0; $i < $maxa;$i++)
              {
                  echo $areaFEVQibuilder[$i] . ",";
              }
              echo "],";
              ?>
              ['MAR',  <?php
               for($i = 0; $i < $maxa;$i++)
               {
                   echo $areaMARQibuilder[$i] . ",";
               }
               echo "],";
               ?>
               ['ABR', <?php
                for($i = 0; $i < $maxa;$i++)
                {
                    echo $areaABRQibuilder[$i] . ",";
                }
                echo "],";
                ?>
                ['MAI', <?php
                 for($i = 0; $i < $maxa;$i++)
                 {
                     echo $areaMAIQibuilder[$i] . ",";
                 }
                 echo "],";
                 ?>
                 ['JUN', <?php
                  for($i = 0; $i < $maxa;$i++)
                  {
                      echo $areaJUNQibuilder[$i] . ",";
                  }
                  echo "],";
                  ?>
                  ['JUL',  <?php
                   for($i = 0; $i < $maxa;$i++)
                   {
                       echo $areaJULQibuilder[$i] . ",";
                   }
                   echo "],";
                   ?>
                   ['AGO',  <?php
                    for($i = 0; $i < $maxa;$i++)
                    {
                        echo $areaAGOQibuilder[$i] . ",";
                    }
                    echo "],";
                    ?>
                    ['SET',  <?php
                     for($i = 0; $i < $maxa;$i++)
                     {
                         echo $areaSETQibuilder[$i] . ",";
                     }
                     echo "],";
                     ?>
                     ['OUT',  <?php
                      for($i = 0; $i < $maxa;$i++)
                      {
                          echo $areaOUTQibuilder[$i] . ",";
                      }
                      echo "],";
                      ?>
                      ['NOV', <?php
                       for($i = 0; $i < $maxa;$i++)
                       {
                           echo $areaNOVQibuilder[$i] . ",";
                       }
                       echo "],";
                       ?>
                       ['DEZ',  <?php
                        for($i = 0; $i < $maxa;$i++)
                        {
                            echo $areaDEZQibuilder[$i] . ",";
                        }
                        echo "],";
                        ?>
                       ]);

                       var options = {
                       title: 'QiBuilder - Número de crashes por mês, ano e versão',
                       hAxis: {title: 'Mês',  titleTextStyle: {color: '#333'}},
                       vAxis: {minValue: 0}
                       };
                       var chart = new google.visualization.AreaChart(document.getElementById('chart_div2'));
                       chart.draw(data, options);
                       }
</script>
<?php echo 'oii';?>
<?php echo $janeiroqi;?>
<div id="chart_div2" style="width: 100%; height: 500px;"></div>

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

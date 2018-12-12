<?php
$con = new mysqli("localhost", "root", "", "tiendan");
//$sql = "SELECT fecha_muestra, ph, temperatura_m, humedad, presion_atmosferica FROM muestra_prueba";
$sql = "SELECT DISTINCT(empleo), COUNT(*) as cantidad FROM `estudiante` where 1 group by empleo";
$res = $con->query($sql);
$sql2 = "SELECT DISTINCT(ciudad), COUNT(*) as cantidad FROM `estudiante` where 1 group by ciudad";
$res2 = $con->query($sql2);
$con->close();
?>
<!doctype html>
<html lang="es">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="vista/css/bootstrap.min.css">
    <link rel="stylesheet" href="vista/css/style.css">
  </head>
  <body>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Genero', 'Cantidad'],
          ['Femenino', 0],
          ['Masculino', 0]
        ]);

        var options = {
          title: "Mujeres y hombres en la organizacion"
        };
        var chart3 = new google.visualization.PieChart(document.getElementById('piechart'));
        //Grafico imagen 1
        var chart_area = document.getElementById('piechart_3d');
        var chart = new google.visualization.PieChart(chart_area);
        google.visualization.events.addListener(chart, 'ready', function(){
            chart_area.innerHTML = '<img src="' + chart.getImageURI() + '" class="img-responsive">';
            });
        //Grafico imagen 2
        var chart_area2 = document.getElementById('piechart_3d2');
        var chart2 = new google.visualization.PieChart(chart_area2);
        google.visualization.events.addListener(chart2, 'ready', function(){
            chart_area2.innerHTML = '<img src="' + chart2.getImageURI() + '" class="img-responsive">';

        });
        setInterval(function() {
          var JSON=$.ajax({
            url:"vista/consulta.php",
            dataType: 'json',
            async: false
          }).responseText;
          var Respuesta=jQuery.parseJSON(JSON);

          data.setValue(0, 1, Respuesta[0].cantidad);
          data.setValue(1, 1, Respuesta[1].cantidad);
          chart.draw(data, options);
          chart2.draw(data, options);
          chart3.draw(data, options);
        }, 1000);
      }
    </script>
        <div class="container">
          <div class="jumbotron">
          <h1 class="display-4">Juan Sebastian Guayana Gallegos</h1>
          <p class="lead">Ficha: 1595907</p>
          <hr class="my-4">
          <p>Aqui podrás generar un documento pdf con datos de trabajadores, sus cuidades y la labor que desempeñan.</p>
          <form style="margin-bottom:10px" action="vista/archivo.php" method="post" id="make_pdf">
            <input type="hidden" name="hidden_html" id="hidden_html"/>
            <button class="btn btn-primary btn-lg" type="button" name="create_pdf" id="create_pdf" >PDF Job_Title</button>
          </form>
          <form style="margin-bottom:10px" action="vista/archivo.php" method="post" id="make_pdf2">
            <input type="hidden" name="hidden_html" id="hidden_html"/>
            <button class="btn btn-primary btn-lg" type="button" name="create_pdf2" id="create_pdf2" >PDF City</button>
          </form>
        </div>
        
    </div>
<div class="container">
      <div id="piechart" style="width: 900px; height: 500px;"></div>
</div>
<div class="container" id="testing">
  <div id="piechart_3d" style="width: 900px; height: 500px; opacity:0;"></div>
  <div class="container" id="tabla" style="display:none">
          <div class="jumbotron">
          <h1 class="display-4">Trabajos</h1>
          <p class="lead">Empleos de los usuarios registrados</p>
          <hr class="my-4">
          <p>Tabla con los empleos de los usuarios.</p>
          
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Empleo</th>
                <th scope="col">Numero de trabajadores</th>
              </tr>
            </thead>
            <tbody>
<?php
                while ($fila = $res->fetch_assoc()) {
                    //$fecha = explode("-", $fila["fecha_muestra"]);
                    echo "<tr>
                    <td>" . $fila['empleo'] . "</td>
                    <td>" . $fila['cantidad'] . "</td>
                    <tr>";
                }
?>
            </tbody>
          </table>


        </div> 
    </div>
</div>
<div class="container" id="testing2">
  <div id="piechart_3d2" style="width: 900px; height: 500px; opacity:0;"></div>
  <div class="container" id="tabla2" style="display:none">
          <div class="jumbotron">
          <h1 class="display-4">Ciudades</h1>
          <p class="lead">Ciudades de los usuarios registrados</p>
          <hr class="my-4">
          <p>Tabla con las Ciudades de los usuarios.</p>
          
          <table class="table">
            <thead class="thead-dark">
              <tr>
                <th scope="col">Ciudad</th>
                <th scope="col">Numero de trabajadores</th>
              </tr>
            </thead>
            <tbody>
<?php
                while ($fila = $res2->fetch_assoc()) {
                    //$fecha = explode("-", $fila["fecha_muestra"]);
                    echo "<tr>
                    <td>" . $fila['ciudad'] . "</td>
                    <td>" . $fila['cantidad'] . "</td>
                    <tr>";
                }
?>
            </tbody>
          </table>


        </div> 
    </div>
</div>

<script>
    $(document).ready(function(){
      $('#create_pdf').click(function(){
        $('#piechart_3d').css("opacity", "1");
        $('#tabla').removeAttr("style");
        $('#hidden_html').val($('#testing').html());
        $("#make_pdf").submit();
      });
      $('#create_pdf2').click(function(){
        $('#testing2 #piechart_3d2').css("opacity", "1");
        $('#tabla2').removeAttr("style");
        $('#make_pdf2 #hidden_html').val($('#testing2').html());
        $("#make_pdf2").submit();
      });
    });
</script>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->

    <script src="vista/js/popper.min.js"></script>
    <script src="vista/js/bootstrap.min.js"></script>

  </body>
</html>
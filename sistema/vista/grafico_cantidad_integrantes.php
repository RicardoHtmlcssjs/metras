<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<!--script src="https://cdn.jsdelivr.net/npm/chart.js"></script-->

	<script>
			const ctx = document.getElementById('myChart').getContext('2d');

			function handleHover(evt, item, legend) {
			  legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
			    colors[index] = index === item.index || color.length === 9 ? color : color + '4D';
			  });
			  legend.chart.update();
			}

			function handleLeave(evt, item, legend) {
			  legend.chart.data.datasets[0].backgroundColor.forEach((color, index, colors) => {
			    colors[index] = color.length === 9 ? color.slice(0, -2) : color;
			  });
			  legend.chart.update();
			}

			function download() {
				const imageLink = document.createElement('a');
				const canvas = document.getElementById('myChart');
				imageLink.download = 'integrantes_por_municipio.png';
				imageLink.href = canvas.toDataURL('image/png',1);
				//window.open(imageLink);
				//document.write('<img src=" '+imageLink+' "/>');
				//console.log(imageLink.href);
				imageLink.click();
			}

			const data = {
		        labels:[
		            <?php
					    require_once "../modelo/mod_mesa.php";
					    $obj_mesa=new mesas();
					    $estado=$_POST['filtro'];
					    $condicion="AND fk_estado='$estado'";				    
					    $consultar_cant_integrantes=$obj_mesa->consultar_cant_integrantes($condicion);
					    while ($resultado=pg_fetch_array($consultar_cant_integrantes)) {
					?>
			             '<?php echo ucwords(strtolower(preg_replace('[\n|\r|\n\r]', '',$resultado["descripcion_municipio"])));?>:'+' <?php echo number_format($resultado["cant_integrantes"], 0, ",", ".");?>',
		            <?php		                					                    
		            	}
		            ?>			            	
		        ],
				//labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
				datasets: [{
					label: 'INTEGRANTES',		    
					data:[
					    <?php
						    require_once "../modelo/mod_mesa.php";
						    $obj_mesa=new mesas();
						    $estado=$_POST['filtro'];
						    $condicion="AND fk_estado='$estado'";
						    $consultar_cant_integrantes=$obj_mesa->consultar_cant_integrantes($condicion);
						    while ($resultado=pg_fetch_array($consultar_cant_integrantes)) {
						?>
					         '<?php echo number_format($resultado["cant_integrantes"], 0, ",", ".");?>',
					    <?php		                					                    
					    	}
					    ?>			            	
					],

				    //data: [12, 19, 3, 5, 2, 3],
				    borderWidth: 1,
				    backgroundColor: ['#CB4335', '#1F618D', '#F1C40F', '#27AE60', '#884EA0', '#D35400'],
				}]
			};

			const config = new Chart(ctx, {
			  type: 'pie',
			  data: data,
			  options: {
			    plugins: {
			      legend: {
			        onHover: handleHover,
			        onLeave: handleLeave
			      }
			    }
			  }
			})
	</script>
</head>
<body>
	<div class="row" style="width: 600px; height: 600px;">
		<div class="panel panel-default">
			<div class="panel-head text-center">
				<h1><?php echo $titulo=$_POST['titulo'];?></h1>
			</div>
			<div class="panel-body">
				<canvas id="myChart"></canvas>
				<button onclick="download();">Descargar</button>
			</div>
		</div>
	</div>
</body>
</html>
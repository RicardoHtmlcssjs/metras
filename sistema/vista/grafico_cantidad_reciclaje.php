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
				imageLink.download = 'reciclaje_por_municipio.png';
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
						
						$tabla="sistema.materiales";
						$campos="*";
						$enlace="";
						$condicion="1=1 ORDER BY pk_material";

					    $consultar_materiales=$obj_mesa->consultar($tabla, $campos, $enlace, $condicion);
					    while ($descripcion_material=pg_fetch_array($consultar_materiales)){
					?>
			             '<?php echo ucwords(strtolower(preg_replace('[\n|\r|\n\r]', '',$descripcion_material["descripcion_material"])));?>',
		            <?php		                					                    
		            	}
		            ?>			            	
		        ],
				//labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
				datasets: [{
					label: 'TONELADAS',		    
					data:[
					    <?php
		                    $municipio=$_POST['filtro'];
		                    $condicion="AND fk_municipio='$municipio'";
		                    $consultar_total_materiales=$obj_mesa->total_reciclaje_municipio($condicion);
                            while ($resultado=pg_fetch_array($consultar_total_materiales)) {
						?>
					         '<?php echo $resultado["total_material_plastico_t"]+($resultado["total_material_plastico_k"]/1000);?>',
					         '<?php echo $resultado["total_material_vidrio_t"]+($resultado["total_material_vidrio_k"]/1000);?>',
					         '<?php echo $resultado["total_material_carton_t"]+($resultado["total_material_carton_k"]/1000);?>',
					         '<?php echo $resultado["total_material_organico_t"]+($resultado["total_material_organico_k"]/1000);?>',
					         '<?php echo $resultado["total_material_papel_t"]+($resultado["total_material_papel_k"]/1000);?>',
					         '<?php echo $resultado["total_material_baterias_t"]+($resultado["total_material_baterias_k"]/1000);?>',
					         '<?php echo $resultado["total_material_ferroso_t"]+($resultado["total_material_ferroso_k"]/1000);?>',
					         '<?php echo $resultado["total_material_textiles_t"]+($resultado["total_material_textiles_k"]/1000);?>',
					         '<?php echo $resultado["total_material_neumaticos_t"]+($resultado["total_material_neumaticos_k"]/1000);?>',
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
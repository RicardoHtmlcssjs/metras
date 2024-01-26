<?php
	require_once "../modelo/mod_mesa.php";

	$desde=$_POST['desde'];
	$hasta=$_POST['hasta'];
	$mesa=$_POST['mesa'];

	$obj_mesa=new mesas();

	$condicion="AND fecha BETWEEN '$desde' AND '$hasta' AND fk_mesa_cantidad=$mesa";
	$consultar_total_materiales=$obj_mesa->consultar_total_reciclaje($condicion);
	while ($resultado=pg_fetch_array($consultar_total_materiales)) {
?>
		<tr>
			<td>PLASTICO</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_plastico_t']+($resultado['total_material_plastico_k']/1000), 2, ",", ".");?></td>
		</tr>
		<tr>
			<td>VIDRIO</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_vidrio_t']+($resultado['total_material_vidrio_k']/1000), 2, ",", ".");?></td>			
		</tr>
		<tr>
			<td>CARTON</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_carton_t']+($resultado['total_material_carton_k']/1000), 2, ",", ".");?></td>			
		</tr>
		<tr>
			<td>ORGANICO</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_organico_t']+($resultado['total_material_organico_k']/1000), 2, ",", ".");?></td>				
		</tr>
		<tr>
			<td>PAPEL</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_papel_t']+($resultado['total_material_papel_k']/1000), 2, ",", ".");?></td>				
		</tr>
		<tr>
			<td>BATERIAS Y PILAS</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_baterias_t']+($resultado['total_material_baterias_k']/1000), 2, ",", ".");?></td>				
		</tr>
		<tr>
			<td>MATERIAL FERROSO NO ESTRATEGICO</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_ferroso_t']+($resultado['total_material_ferroso_k']/1000), 2, ",", ".");?></td>				
		</tr>
		<tr>
			<td>TEXTILES</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_textiles_t']+($resultado['total_material_textiles_k']/1000), 2, ",", ".");?></td>				
		</tr>
		<tr>
			<td>NEUMÁTICOS FUERA DE USO</td>
			<td class="text-right"><?php echo number_format($resultado['total_material_neumaticos_t']+($resultado['total_material_neumaticos_k']/1000), 2, ",", ".");?></td>				
		</tr>				
<?php
	}
?>
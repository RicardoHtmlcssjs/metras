<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" id="materiales-municipio">
                <thead>
                    <tr>
                      <th>Materiales</th>
                      <th>Peso Total en Toneladas</th>
                    </tr>
                </thead>
                <tbody class="body_tabla">
                    <?php
                     require_once "../modelo/mod_mesa.php";
                      $obj_mesa=new mesas();
                      $municipio=$_POST['municipio'];
                      //$condicion="AND fk_mesa_cantidad=$mesa";
                      $condicion="AND fk_municipio='$municipio'";
                      $consultar_total_materiales=$obj_mesa->total_reciclaje_municipio($condicion);
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
                </tbody>
            </table>
        </div>
    </div>
</div>
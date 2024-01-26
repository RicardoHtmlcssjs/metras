function formulario_materiales(pk, procedimiento){
    var pk=pk;
    var procedimiento=procedimiento;

    $.ajax({
        url: 'sistema/controlador/crud_mesa.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {pk, procedimiento},
    })
    .done(function(resp) {
        //alert(resp);
        $('#contenedor-modales').html(resp);
        $('#formulario_mesa').modal('show');
        /*$.getScript("js/mascara_entrada.js");
        $.getScript("js/validacion_datos.js");*/
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    }); 
}

function formulario_carga_mesa(pk, procedimiento){
    var pk=pk;
    var procedimiento=procedimiento;

    $.ajax({
        url: 'sistema/controlador/crud_mesa.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {pk, procedimiento},
    })
    .done(function(resp) {
        $('#contenedor-modales').html(resp);
        $('#formulario_mesa').modal('show');
        /*$.getScript("js/mascara_entrada.js");
        $.getScript("js/validacion_datos.js");*/
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    }); 
}

function opciones_c_comunal(){
    var afiliado_a=$('#afiliado_a').val();
    if(afiliado_a==1) {
      $('.c_comunal').css({'display': 'block'});
    }else if(afiliado_a==2)  {
      $('.c_comunal').css({'display': 'none'});
    } 
}

function opciones_c_toneladas(){
    var centro_acopio=$('#centro_acopio').val();
    if(centro_acopio==1) {
      $('.c_toneladas').css({'display': 'block'});
    }else if(centro_acopio==2)  {
      $('.c_toneladas').css({'display': 'none'});
    } 
}

function consultar_consejo_comunal(){
    var codigo_situr=$('#codigo_situr').val();

    $.ajax({
      url: 'sistema/controlador/con_consultar_consejo_comunal.php',
      type: 'POST',
      //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
      data: {codigo_situr}
    })
    .done(function(respuesta) {
        if (respuesta==1) {
            alert('Error, Este Consejo Comunal ya esta afiliado a una Mesa.');
            $('#codigo_situr').css('border-color', 'red');
            $('#codigo_situr').val("");
            return false;
        }else if (respuesta==2){
            alert('Error, No Existe Consejo Comunal bajo ese Código');
            $('#codigo_situr').css('border-color', 'red');
            $('#codigo_situr').val("");
            return false;            
        }else {
            $('#nombre_consejo_comunal').val(respuesta);            
        }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });  
}

function consultar_materiales_fecha(mesa){
    var desde=$('#desde').val();
    var hasta=$('#hasta').val();

    if(desde == ''){
        alert('Rango Requerido');
        $('#desde').css({'border-color' : 'red'});
        $('#desde').focus();
        return false;
    }

    if(hasta == ''){
        alert('Rango Requerido');
        $('#hasta').css({'border-color' : 'red'});
        $('#hasta').focus();
        return false;
    }

    $.ajax({
        url: 'sistema/controlador/con_consultar_materiales_fecha.php',
        type: 'POST',
    //  dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {desde, hasta, mesa}
    })
    .done(function(respuesta) {
        $('.body_tabla').html(respuesta);
        /*$('.modal-backdrop').removeClass('modal-backdrop');
        $('.button-cancelar').click();
        $('#menu-materiales').click();*/
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });    
}

function consultar_materiales_municipio(municipio){
    $.ajax({
        url: 'sistema/vista/tabla_materiales_municipio.php',
        type: 'POST',
    //  dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {municipio}
    })
    .done(function(respuesta) {
        //alert(respuesta);
        $('#contenedor-materiales-municipio').html(respuesta);
        /*$('.modal-backdrop').removeClass('modal-backdrop');
        $('.button-cancelar').click();
        $('#menu-materiales').click();*/
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });    
}

function opciones_m_recoleccion(){
    var metodo_recoleccion=$('#metodo_recoleccion').val();
    if(metodo_recoleccion>51 || metodo_recoleccion==0) {
      $('.t_automotor').css({'display': 'none'});
    }else{
      $('.t_automotor').css({'display': 'block'});
      $('#placa').val("");
    } 
}

function crud_materiales(pk, procedimiento){
    var material=$('#material').val();
    var cantidad=$('#cantidad').val();
    var peso=$('#peso').val();            
    var metodo_recoleccion=$('#metodo_recoleccion').val();
    var marca=$('#marca').val();
    var placa=$('#placa').val();
    var ruta_recoleccion=$('#ruta_recoleccion').val();

    if(material == 0 ){
        alert('Material Requerido');
        $('#material').css({'border-color' : 'red'});
        $('#material').focus();
        return false;
    }

    if(cantidad == '' || cantidad == 0){
        alert('Cantidad Invalida');
        $('#cantidad').css({'border-color' : 'red'});
        $('#cantidad').focus();
        return false;
    }

    if(peso == 0){
        alert('Peso Requerido');
        $('#peso').css({'border-color' : 'red'});
        $('#peso').focus();
        return false;
    }

    if(metodo_recoleccion == 0 ){
        alert('Metodo de Recoleccion Requerido');
        $('#metodo_recoleccion').css({'border-color' : 'red'});
        $('#metodo_recoleccion').focus();
        return false;
    }

    if(metodo_recoleccion>51 || metodo_recoleccion==0) {
      marca=0;
      placa="NO APLICA";
    }else{
        if(marca == 0 ){
            alert('Marca Requerida');
            $('#marca').css({'border-color' : 'red'});
            $('#marca').focus();
            return false;
        }

        if(placa == ''){
            alert('Placa Requerida');
            $('#placa').css({'border-color' : 'red'});
            $('#placa').focus();
            return false;
        }        
    }

    if(ruta_recoleccion == ''){
        alert('Ruta de Recoleccion Requerida');
        $('#ruta_recoleccion').css({'border-color' : 'red'});
        $('#ruta_recoleccion').focus();
        return false;
    }              

    $.ajax({
        url: 'sistema/controlador/crud_mesa.php',
        type: 'POST',
    //  dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {pk, procedimiento, material, cantidad, peso, metodo_recoleccion, marca, placa, ruta_recoleccion}
    })
    .done(function(respuesta) {
        alert(respuesta);
        $('.modal-backdrop').removeClass('modal-backdrop');
        $('.button-cancelar').click();
        $('#menu-materiales').click();
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function crud_carga_mesa(pk, procedimiento){
    var nombre_mesa=$('#nombre_mesa').val();
    var estado=$('#estado').val();
    var municipio=$('#municipio').val();
    var parroquia=$('#parroquia').val();        
    var afiliado_a=$('#afiliado_a').val();

    if (afiliado_a==1) {
        var codigo_situr=$('#codigo_situr').val();
    }else if(afiliado_a==2){
        var codigo_situr="NO APLICA";
    }

    var centro_acopio=$('#centro_acopio').val();
    if (centro_acopio==1) {
        var capacidad_toneladas=$('#capacidad_toneladas').val();        
    }else if(centro_acopio==2){
        var capacidad_toneladas=0;
    }

    var poblacion_impactar=$('#poblacion_impactar').val();

    if(nombre_mesa == '' ){
        alert('Nombre de Mesa Requerido');
        $('#nombre_mesa').css({'border-color' : 'red'});
        $('#nombre_mesa').focus();
        return false;
    }

    if(estado == 0 ){
        alert('Estado Requerido');
        $('#estado').css({'border-color' : 'red'});
        $('#estado').focus();
        return false;
    }

    if(municipio == 0 ){
        alert('Municipio Requerido');
        $('#municipio').css({'border-color' : 'red'});
        $('#municipio').focus();
        return false;
    }

    if(parroquia == 0 ){
        alert('Parroquia Requerida');
        $('#parroquia').css({'border-color' : 'red'});
        $('#parroquia').focus();
        return false;
    }

    if(afiliado_a == 0 ){
        alert('Campo Requerido');
        $('#afiliado_a').css({'border-color' : 'red'});
        $('#afiliado_a').focus();
        return false;
    }

    if(codigo_situr == '' ){
        alert('Codigo Situr Requerido');
        $('#codigo_situr').css({'border-color' : 'red'});
        $('#codigo_situr').focus();
        return false;
    }    

    if(centro_acopio == 0 ){
        alert('Campo Requerido');
        $('#centro_acopio').css({'border-color' : 'red'});
        $('#centro_acopio').focus();
        return false;
    }

    if(capacidad_toneladas === '' ){
        alert('Capacidad en Toneladas Requerida');
        $('#capacidad_toneladas').css({'border-color' : 'red'});
        $('#capacidad_toneladas').focus();
        return false;
    }

    if(poblacion_impactar == 0 ){
        alert('Poblacion a Impactar Requerida');
        $('#poblacion_impactar').css({'border-color' : 'red'});
        $('#poblacion_impactar').focus();
        return false;
    }    

    $.ajax({
        url: 'sistema/controlador/crud_mesa.php',
        type: 'POST',
    //  dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {pk, procedimiento, nombre_mesa, estado, municipio, parroquia, codigo_situr, capacidad_toneladas, poblacion_impactar}
    })
    .done(function(respuesta) {
        alert(respuesta);
        $('.modal-backdrop').removeClass('modal-backdrop');
        $('.button-cancelar').click();
        $('#menu-mesas').click();
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
function mostrar(pk, procedimiento){
    alert(pk+" "+procedimiento);
}

function validar(operacion){
	var operacion;

	if (operacion=='registrar' && valido==true){
		registrar_usuario();
	}else if(operacion=='registrar' && valido==true){
		modificar_usuario();
	}

}

function verificar_duplicidad(id){
    var valor=$('#'+id).val();
    var campo=id;
    var nacionalidad=$('#nacionalidad').val();

    if(nacionalidad == 0 ){
        alert('Campo Requerido');
        $('#nacionalidad').css({'border-color' : 'red'});
        $('#nacionalidad').focus();
        return false;
    }

    $.ajax({
        url: 'usuario/controlador/con_verificar_duplicidad.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {valor, campo, nacionalidad}
    })
    .done(function(respuesta) {
        if (respuesta==1) {
            alert("<strong>Error!</strong> Ya Existe un Usuario con esta Cedula.");
            $('#'+id).css('border-color', 'red');
            $('#'+id).val("");
            return false; 
        }else if (respuesta==2) {
            alert("<strong>Error!</strong> Ya Existe un Usuario con este Correo.");
            $('#'+id).css('border-color', 'red');
            $('#'+id).val("");
            return false;
        }else if (respuesta==3) {
            alert("<strong>Error!</strong> Ya Existe un Usuario con este Telefono.");
            $('#'+id).css('border-color', 'red');
            $('#'+id).val("");
            return false;
        }else if (respuesta=='valida') {
            $('#'+id).css('border-color', 'rgba(0, 0, 0, 0.2)');
        }else{
            $('#'+id).css('border-color', 'rgba(0, 0, 0, 0.2)');
            $('.consulta_saime').html(respuesta);            
        }
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function estado_sesion(accion){
    if (accion=="abrir") {
        var nombre_usuario=$('#usuario').val();
        var clave_usuario=$('#clave').val();        
    }else{
        var nombre_usuario="";
        var clave_usuario="";        
    }
    var accion=accion;
    $.ajax({
        url: 'usuario/controlador/con_session.php',
        type: 'POST',
    //  dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {nombre_usuario, clave_usuario, accion},
        success: function(respuesta){
            if (respuesta=='datos-validos') {
                        window.location="menu.php";            
                    }else if (respuesta=='sesion-cerrada') {
                        window.location.href = "index.php";
                    }else if (respuesta=='datos-invalidos') {
                        alert('Usuario y/o Contraseña Invalidos');
                        $("#res").html("");
                    }else{
                        $("#res").html("<div style='font-size: 20px;' class='alert alert-danger text-center' role='alert'>Ha ocurrido un error.</div>");
                        console.log(respuesta);
                    }

        },
        error: function(error){
            alert("ha ocurrido un error");
             console.log(error);
        }
    })

    // .done(function(respuesta) {
    //     if (respuesta=='datos-validos') {
    //         window.location="menu.php";            
    //     }else if (respuesta=='sesion-cerrada') {
    //         window.location.href = "index.php";
    //     }else if (respuesta=='datos-invalidos') {
    //         alert('Usuario y/o Contraseña Invalidos');
    //     }
    // })
    // .fail(function() {
    //     alert('error');
    // });
}

function formulario_cambiar_clave(){
    $.ajax({
        url: 'usuario/vista/cambiar_clave.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        //data: {pk, procedimiento},
    })
    .done(function(resp) {
        $('#contenedor-modales').html(resp);
        $('#formulario_recuperar_clave').modal('show');
        //$.getScript("js/mascara_entrada.js");
        //$.getScript("sistema/js/validacion_datos.js");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function cambiar_clave(usuario){
    $('.button-registrar').attr("disabled", true);
    $('.button-registrar').text("Procesando...");    
    var clave_actual=$('#clave_actual').val();
    var nueva_clave=$('#nueva_clave').val();
    var repita_clave=$('#repita_clave').val();

    if(clave_actual == '' ){
        alert('Clave Actual Requerida');
        $('#clave_actual').css({'border-color' : 'red'});
        $('.button-registrar').attr("disabled", false);
        $('.button-registrar').text("Cambiar");
        return false;
    }

    if(nueva_clave == '' ){
        alert('Campo Requerido');
        $('#nueva_clave').css({'border-color' : 'red'});
        $('.button-registrar').attr("disabled", false);
        $('.button-registrar').text("Cambiar");
        return false;
    }

    if(repita_clave == '' ){
        alert('Campo Requerido');
        $('#repita_clave').css({'border-color' : 'red'});
        $('.button-registrar').attr("disabled", false);
        $('.button-registrar').text("Cambiar");
        return false;
    }

    if(nueva_clave != repita_clave){
        alert('Claves deben Coincidir');
        $('#nueva_clave').css({'border-color' : 'red'});        
        $('#repita_clave').css({'border-color' : 'red'});
        $('.button-registrar').attr("disabled", false);
        $('.button-registrar').text("Cambiar");
        return false;
    }

    $.ajax({
        url: 'usuario/controlador/con_cambiar_clave.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {clave_actual, usuario, nueva_clave},
    })
    .done(function(resp) {
        alert(resp);
        $('.close').click();
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function formulario_recuperar_clave(){
    $.ajax({
        url: 'usuario/vista/recuperar_clave.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        //data: {pk, procedimiento},
    })
    .done(function(resp) {
        $('#contenedor-modales').html(resp);
        $('#formulario_recuperar_clave').modal('show');
        //$.getScript("js/mascara_entrada.js");
        $.getScript("sistema/js/validacion_datos.js");
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    }); 
}

function recuperar_clave(pk,procedimiento){
    $('.button-registrar').attr("disabled", true);
    $('.button-registrar').text("Procesando...");
    var cedula=$('#cedula').val();
    var correo=$('#correo').val();

    if(cedula == '' ){
        alert('Cedula Requerida');
        $('#cedula').css({'border-color' : 'red'});
        $('#cedula').focus();
        $('.button-registrar').attr("disabled", false);
        $('.button-registrar').text("Recuperar");        
        return false;
    }
    if(correo == '' ){
        alert('Correo Requerido');
        $('#correo').css({'border-color' : 'red'});
        $('#correo').focus();
        $('.button-registrar').attr("disabled", false);
        $('.button-registrar').text("Recuperar");          
        return false;
    }

    $.ajax({
        url: 'usuario/controlador/con_recuperar_clave.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {cedula, correo},
    })
    .done(function(resp) {
        alert(resp);
        $('.close').click();
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}

function formulario_usuario(pk,procedimiento){
    var pk=pk;
    var procedimiento=procedimiento;

    $.ajax({
        url: 'usuario/controlador/crud_usuario.php',
        type: 'POST',
        //dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {pk, procedimiento},
		
    })
    .done(function(resp) {
        alert("hola");
        $('#contenedor-modales').html(resp);
        $('#formulario_usuario').modal('show');
        //$.getScript("js/mascara_entrada.js");
        $.getScript("sistema/js/validacion_datos.js");
    })
    .fail(function(error) {
        $("#res").html("hola");
        alert("Ha ocurrido un error");
        console.log(error);
    })
    .always(function() {
        console.log("complete");
        alert("fino");
    }); 
}

function crud_usuario(pk, procedimiento){
    var cedula=$('#cedula').val();
    var nacionalidad=$('#nacionalidad').val();
    var nombre=$('#nombre').val();
    var apellido=$('#apellido').val();
    var genero=$('#genero').val();
    var edad=$('#edad').val();
    var nivel_academico=$('#nivel_academico').val();   
    var correo=$('#correo').val();
    var telefono=$('#telefono').val();
    //var privilegio=$('#privilegio').val();
    //var estatus=$('#estatus').val();
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

    var expreg = /^[a-zA-Z ]+$/;
    var formato_correo=/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/;
    var formato_c_n_e=/^[A-Za-z0-9]/g;
    var numerico=/^[0-9]+$/;

    var centro_acopio=$('#centro_acopio').val();
    if (centro_acopio==1) {
        var capacidad_toneladas=$('#capacidad_toneladas').val();        
    }else if(centro_acopio==2){
        var capacidad_toneladas=0;
    }

    var poblacion_impactar=$('#poblacion_impactar').val();

    if(nacionalidad == 0 ){
        alert('Campo Requerido');
        $('#nacionalidad').css({'border-color' : 'red'});
        $('#nacionalidad').focus();
        return false;
    }

    if(cedula == '' ){
        alert('Cedula Requerida');
        $('#cedula').css({'border-color' : 'red'});
        $('#cedula').focus();
        return false;
    }

    if(nombre == ''){
        alert('Nombre Requerido');
        $('#nombre').css({'border-color' : 'red'});
        $('#nombre').focus();
        return false;
    }

    if(expreg.test(nombre)){
        //alert("La formato es valido"); 
    }else{
        alert("Nombre Invalido, Verifique no estar usando Caracteres especiales");
        $('#nombre').css({'border-color' : 'red'});
        $('#nombre').focus();
        return false;        
    }

    if(apellido == '' ){
        alert('Apellido Requerido');
        $('#apellido').css({'border-color' : 'red'});
        $('#apellido').focus();
        return false;
    }

    if(expreg.test(apellido)){
        //alert("La formato es valido"); 
    }else{
        alert("Apellido Invalido, Verifique no estar usando Caracteres especiales");
        $('#apellido').css({'border-color' : 'red'});
        $('#apellido').focus();
        return false;        
    }    

    if(genero == 0 ){
        alert('Genero Requerido');
        $('#genero').css({'border-color' : 'red'});
        $('#genero').focus();
        return false;
    }

    if(edad == '' ){
        alert('Edad Requerida');
        $('#edad').css({'border-color' : 'red'});
        $('#edad').focus();
        return false;
    }

    if(edad.match(numerico)==null) {
        alert('Error, Formato Invalido');
        $('#edad').css({'border-color' : 'red'});
        $('#edad').focus();
        return false;        
    }

    if(nivel_academico == 0 ){
        alert('Nivel Academico Requerido');
        $('#nivel_academico').css({'border-color' : 'red'});
        $('#nivel_academico').focus();
        return false;
    }

    if(correo == '' ){
        alert('Correo Requerido');
        $('#correo').css({'border-color' : 'red'});
        $('#correo').focus();
        return false;
    }

    if(formato_correo.test(correo)){
        //alert("El formato es valido"); 
    }else{
        alert("Error, el formato del correo no es válido");
        $('#correo').css({'border-color' : 'red'});
        $('#correo').focus();
        return false;        
    }

    if(telefono == '' ){
        alert('Telefono Requerido');
        $('#telefono').css({'border-color' : 'red'});
        $('#telefono').focus();
        return false;
    }

    if(telefono.match(numerico)==null) {
        alert('Error, Formato Invalido');
        $('#telefono').css({'border-color' : 'red'});
        $('#telefono').focus();
        return false;        
    }

    if(nombre_mesa == '' ){
        alert('Nombre de Mesa Requerido');
        $('#nombre_mesa').css({'border-color' : 'red'});
        $('#nombre_mesa').focus();
        return false;
    }

    if(formato_c_n_e.test(nombre_mesa)){
        //alert("La formato es valido"); 
    }else{
        alert("Error, Introduzca un Nombre Valido.");
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

    if (centro_acopio==1) {
        if(capacidad_toneladas.match(numerico)==null) {
            alert('Error, Formato Invalido');
            $('#capacidad_toneladas').css({'border-color' : 'red'});
            $('#capacidad_toneladas').focus();
            return false;        
        }
    }

    if(poblacion_impactar == 0 ){
        alert('Poblacion a Impactar Requerida');
        $('#poblacion_impactar').css({'border-color' : 'red'});
        $('#poblacion_impactar').focus();
        return false;
    }

    if(poblacion_impactar.match(numerico)==null) {
        alert('Error, Formato Invalido');
        $('#poblacion_impactar').css({'border-color' : 'red'});
        $('#poblacion_impactar').focus();
        return false;        
    }       

    $('.button-cancelar').attr("disabled", true);
    $('.button-registrar').attr("disabled", true);
    $('.button-registrar').text("Procesando...");

    $.ajax({
        url: 'usuario/controlador/crud_usuario.php',
        type: 'POST',
    //  dataType: 'default: Intelligent Guess (Other values: xml, json, script, or html)',
        data: {pk, procedimiento, nacionalidad, cedula, nombre, apellido, genero, edad, nivel_academico, correo, telefono, nombre_mesa, estado, municipio, parroquia, codigo_situr, capacidad_toneladas, poblacion_impactar}
    })
    .done(function(respuesta) {
        if (respuesta==2) {
            alert("Error, Operación Fallida");
        }else if(respuesta==1){
            alert("Registro de Usuario Exitoso");
        }else if(respuesta==4){
            alert("Modificacion de Usuario Exitosa");
        }else{
            alert("Registro de Usuario y Mesa Exitoso");
        }
        $('.button-cancelar').attr("disabled", false);
        $('.modal-backdrop').removeClass('modal-backdrop');
        $('.button-cancelar').click();
        $('#menu-integrantes').click();
    })
    .fail(function() {
        console.log("error");
    })
    .always(function() {
        console.log("complete");
    });
}
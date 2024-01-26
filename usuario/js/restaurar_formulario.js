
$('.button').click(function() {
  $('#collapse1').removeClass('show');
  $('.primer-grupo').click();
});

/*
$('.button-mod').click(function() {
  $('.primer-grupo-mod').click();
});*/

function restaurar_modal(){
  $('#newserial').val('');
  $('#newnro_bien').val('');
  $('#newsistema_operativo').val('');
  $('#newdisco_duro').val('');
  $('#newcapacidad').val('0');
  $('#newprocesador').val('');
  $('#newconexion_red').val('');
  $('#newmac_adress').val('');
  $('#newfuente_poder').val('');
  $('#newtarjeta_madre').val('');
  $('#newaplicaciones').val('');
  $('#newmarca').val('0');
  $('#newmodelo').html('<option selected value="0">SELECCIONE...</option>');
  $('#newestatus').val('0');
  $('.newdetalles_estatus').css({'display': 'none'});
  $('#newdetalles_estatus').val('');
  $('#newdea').val('0');
  $('#newdireccion_general').val('0');
  $('#newdireccion_linea').val('0');
  $('#newcedula_responsable_directo').val('');
  $('#newnombre_responsable_directo').val('');
  $('#newcedula_responsable_indirecto').val('');
  $('#newnombre_responsable_indirecto').val(''); 
  $('#newpiso').val('0');
  $('.detalles_newubicacion').css({'display': 'none'});
  $('#detalles_newubicacion').val('');
  $('#newobservaciones').val(''); 
}  
      

//MODALES DE REGISTRO   
/*function cargar_modal_monitor(){
    document.getElementById('button-registro').setAttribute("onclick", "registrar_monitor();");
    $('#registrar-equipo').modal('show'); 
}

function cargar_modal_mouse(){
    document.getElementById('button-registro').setAttribute("onclick", "registrar_mouse();");
    $('#registrar-equipo').modal('show'); 
}

function cargar_modal_teclado(){
    document.getElementById('button-registro').setAttribute("onclick", "registrar_teclado();");
    $('#registrar-equipo').modal('show'); 
}
      
function cargar_modal_impresora(){
    document.getElementById('button-registro').setAttribute("onclick", "registrar_impresora();");
    $('#registrar-equipo').modal('show'); 
}*/
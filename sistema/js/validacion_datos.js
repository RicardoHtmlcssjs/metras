$(document).ready(function (){

  $('.tiponumerico').keyup(function (){
    this.value = (this.value).replace(/[^0-9]/g, '');
  });

  $('.tipocaracter').keyup(function (){
    this.value = (this.value).replace(/[^a-z]+$/i, '');
  });
});
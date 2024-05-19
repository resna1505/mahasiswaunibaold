$(document).ready(function(){
  $('table:not(.reset) tbody tr:even').removeClass('pesanlama').addClass('genap');

  $('table:not(.reset) tbody tr:odd').removeClass('pesanlama').addClass('ganjil');
  
  //$('table.tbody tr:even').removeClass('genap');

 // $('tbody tr:odd').removeClass('ganjil');
  
  $('hr').hide();
  
  $('.hide').hide();
  
  $('select').addClass('masukan');
  
  $('input').addClass('masukan');
  
  $('.postcontent ul').addClass('list');
  
  $('.postcontent img').removeClass('lefticon');
  
  $(':submit').removeClass('masukan').removeClass('tombol').addClass('show');
  
  $(':reset').removeClass('masukan').removeClass('tombol').addClass('show');
  
});
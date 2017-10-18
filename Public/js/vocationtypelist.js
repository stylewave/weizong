$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'TYPE_ADD_SUCCESS'){
    $('.errmess').text('添加类型成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Vocationtype/list_vocationtype');

  }
  if( tip == 'TYPE_ADD_FALSE'){
    $('.errmess').text('添加类型失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Vocationtype/list_vocationtype');

  }
  if( tip == 'TYPE_UPDATE_SUCCESS'){
    $('.errmess').text('修改类型成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Vocationtype/list_vocationtype');

  }
  if( tip == 'TYPE_UPDATE_FALSE'){
    $('.errmess').text('修改类型失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Vocationtype/list_vocationtype');
  }
});
$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'COMPANY_ADD_SUCCESS'){
    $('.errmess').text('添加部门成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Company/list_company');

  }
  if( tip == 'COMPANY_ADD_FALSE'){
    $('.errmess').text('添加部门失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Company/list_company');

  }
  if( tip == 'COMPANY_UPDATE_SUCCESS'){
    $('.errmess').text('修改部门信息成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Company/list_company');

  }
  if( tip == 'COMPANY_UPDATE_FALSE'){
    $('.errmess').text('修改部门信息失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Company/list_company');

  }
});
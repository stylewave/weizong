$(document).ready(function(){
  var tip=$('#errtip').html();
  // var redirecturl = '/hyx/index.php/Home';
  if( tip == 'PDFEXT_UPDATE_SUCCESS'){
    $('.errmess').text('修改PDF拓展成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');

  }
  if( tip == 'PDFEXT_UPDATE_FALSE'){
    $('.errmess').text('修改PDF拓展失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');
  }
  if( tip == 'PDFEXT_ADD_SUCCESS'){
    $('.errmess').text('增加PDF拓展成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');

  }
  if( tip == 'PDFEXT_ADD_FALSE'){
    $('.errmess').text('增加PDF拓展失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');
  }
  if( tip == 'PDFEXT_SETCONTENT_SUCCESS'){
    $('.errmess').text('设置PDF拓展内容成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');

  }
  if( tip == 'PDFEXT_SETCONTENT_FALSE'){
    $('.errmess').text('设置PDF拓展内容失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');
  }
  if( tip == 'PDFEXT_DELETE_SUCCESS'){
    $('.errmess').text('删除PDF拓展成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');

  }
  if( tip == 'PDFEXT_DELETE_FALSE'){
    $('.errmess').text('删除PDF拓展失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');
  }
  if( tip == 'EXPANDSWITCH_SUCCESS'){
    $('.errmess').text('设置PDF拓展操作成功').css('color','green');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');

  }
  if( tip == 'EXPANDSWITCH_FALSE'){
    $('.errmess').text('设置PDF拓展操作失败').css('color','red');
    $('#errmess').show();
    $('#sure-err a').attr('href',redirecturl+'/Manage/pdfext_list');
  }
  
});
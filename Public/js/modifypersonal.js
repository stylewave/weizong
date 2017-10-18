 $('input[name=pwd1]').blur(function(){
  var pwd1 = $(this).val();
  if( pwd1.length < '6' || pwd1.length > '18'){
    $('#pwd1info').html('请输入6-18位字符');
  }else{
    $('#pwd1info').html('');
  }
});
$('input[name=pwd2]').blur(function(){
  var pwd1  = $('input[name=pwd1]').val().toString();
  var pwd2  = $('input[name=pwd2]').val().toString();
  if(pwd1 != pwd2){
    $('#pwd2info').html('和上一次输入的密码不同');
  }else{
    $('#pwd2info').html('');
  }
});
$('#formsubmit1').click(function(){
 var pwd1 = $('input[name=pwd1]').val().toString();
 var pwd2 = $('input[name=pwd2]').val().toString();
 if( $('#pwd1info').html().length == 0 && $('#pwd2info').html().length ==0 && pwd1 == pwd2){
   var hash = hex_md5($('input[name=pwd2]').val());
   hash = hash.substr(25,31);
   $('input[name=pwd2]').val(hash);
   $('input[name=pwd1]').val('');
   $('#form1').submit();
 }else{
   $('#pwd2info').html('请输入符合要求的密码,并确认两次密码都相同');
 }
});

$('input[name=phone]').blur(function(){
  if(checkPhone($(this).val()) == true){
    $('#phoneinfo').html('&nbsp;');
  }else{
     $('#phoneinfo').html('请填写正确的联系号码');
  }
});

$('#formsubmit2').click(function(){
  if($('#phoneinfo').html() == '&nbsp;'){
    $('#form2').submit();
  }else{
    $('#phoneinfo').html('请填写正确的联系号码');
  }
});

$('input[name=uploadlimit]').blur(function(){
  if(!isNaN($(this).val())){
     $('#uploadinfo').html('&nbsp;');
  }else{
    $('#uploadinfo').html('请填写正整数');

  }
});
$('input[name=downlimit]').blur(function(){
  if(!isNaN($(this).val())){
    $('#downinfo').html('&nbsp;');
  }else{
    $('#downinfo').html('请填写正整数');
  }
});

$('#formsubmit3').click(function(){
  if($('#downinfo').html() == '&nbsp;' && $('#uploadinfo').html() =='&nbsp;'){
    $('#form3').submit();
  }else{
    $('#limitErrorInfo').html('请在上传或下载限制中填写正整数');
  }
});

$('select[name=usertype]').change(function(){
   var value = $(this).val();
   if(value =='2'){
      $('#company').show();$('#vocation').hide();
   }else if(value=='3'){
      $('#company').hide();$('#vocation').show();
   }else{
      $('#company').hide();$('#vocation').hide();
   }
});

$(function(){
    if($('#down1').attr('checked') =='checked'){
        $('#downtimespace').hide();
    }
    if($('#upload1').attr('checked') == 'checked'){
        $('#uploadtimespace').hide();
    }
});

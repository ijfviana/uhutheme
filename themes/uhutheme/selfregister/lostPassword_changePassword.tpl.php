<?php
$this->data['header'] = $this->t('lpw_head', $this->data['systemName']);
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$config = \SimpleSAML\Configuration::getInstance();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
?>
<?php

$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$this->includeAtTemplateBase('includes/header_uhu.php'); ?>

<?php
if (isset($this->data['error'])) {
?>

  <div class="alert alert-danger">
	   <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	    <strong>¡Error!</strong> <?php echo $this->data['error']; ?>
  </div>

<?php
}
?>
<!--
<h1><?php echo $this->t('lpw_head'); ?></h1>
<p><?php echo $this->t('lpw_reg_para1', ['%UID%' => $this->data['uid']]); ?> 
	<?php echo $this->t('lpw_password_guide')?></p>
-->
<?php //print $this->data['formHtml'];
?>
<div class="container">
<div class="row">
<div class="col-sm-12">
<!-- <h1>Change Password</h1> -->
</div>
</div>
<div class="row">
<div class="col-sm-6 col-sm-offset-3">
<p class="text-center"><?php echo $this->t('{selfregister:selfregister:lpw_password_form}'); ?></p>
<form class="form-horizontal" method="post" role="form" id="passwordForm" action="lostPassword.php";>
<input type="hidden" name="emailconfirmed" value="<?php print($this->data['hidden']['emailconfirmed']);?>" />
<input type="hidden" name="token" value="<?php print($this->data['hidden']['token']);?>" />
<!-- <input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off"> -->
<!-- <input type="password" class="input-lg form-control"  id="pw1" name="pw1" value=""  placeholder="Nueva contraseña" autoccomplete="off" /> -->

<div class="form-group">
 
<!-- <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-red"></i></span> -->
<label for="pw1" class="col-sm2 control-label"></label>
<input type="password" class="input-lg form-control" id="pw1" name="pw1" placeholder="<?php echo $this->t('reset_pw_newpassword'); ?>" value="" autocomplete="off" />    

</div>


<div class="row">
<div class="col-sm-6">
<span id="8char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos longitud 8<br>
<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos una mayúscula
</div>
<div class="col-sm-6">
<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos una minúscula<br>
<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Al menos un número
</div>
</div>
<!-- <input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off"> -->
<!-- <input type="password" class="input-lg form-control"  id="pw2" name="pw2" value=""  placeholder="Repita la contraseña" autocomplete="off" /> -->

<div class="form-group">
<!-- <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-red"></i></span> -->
<label for="pw2" class="col-sm2 control-label"></label>
<input type="password" class="input-lg form-control" id="pw2" name="pw2" placeholder="<?php echo $this->t('reset_pw_repeatnewpassword'); ?>" value="" autocomplete="off" />    

</div>


<div class="row">
<div class="col-sm-12">
<span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Contraseñas coinciden
</div>
</div>

<div class="form-group">
	<label for="sender" class="col-sm2 control-label"></label>
<input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="cambiando contraseña..." name="sender" value="<?php echo $this->t('reset_pw_accept'); ?>" />
</div>
</form>
</div><!--/col-sm-6-->
</div><!--/row-->
</div>
<script type="text/javascript">
$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	
	if($("#pw1").val().length >= 8){
		$("#8char").removeClass("glyphicon-remove");
		$("#8char").addClass("glyphicon-ok");
		$("#8char").css("color","#00A41E");
	}else{
		$("#8char").removeClass("glyphicon-ok");
		$("#8char").addClass("glyphicon-remove");
		$("#8char").css("color","#FF0004");
	}
	
	if(ucase.test($("#pw1").val())){
		$("#ucase").removeClass("glyphicon-remove");
		$("#ucase").addClass("glyphicon-ok");
		$("#ucase").css("color","#00A41E");
	}else{
		$("#ucase").removeClass("glyphicon-ok");
		$("#ucase").addClass("glyphicon-remove");
		$("#ucase").css("color","#FF0004");
	}
	
	if(lcase.test($("#pw1").val())){
		$("#lcase").removeClass("glyphicon-remove");
		$("#lcase").addClass("glyphicon-ok");
		$("#lcase").css("color","#00A41E");
	}else{
		$("#lcase").removeClass("glyphicon-ok");
		$("#lcase").addClass("glyphicon-remove");
		$("#lcase").css("color","#FF0004");
	}
	
	if(num.test($("#pw1").val())){
		$("#num").removeClass("glyphicon-remove");
		$("#num").addClass("glyphicon-ok");
		$("#num").css("color","#00A41E");
	}else{
		$("#num").removeClass("glyphicon-ok");
		$("#num").addClass("glyphicon-remove");
		$("#num").css("color","#FF0004");
	}
	
	if($("#pw1").val() == $("#pw2").val()){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
	}
})
</script>
<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

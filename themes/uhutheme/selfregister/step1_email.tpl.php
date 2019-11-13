<?php
$this->data['header'] = $this->t('s1_head', $this->data['systemName']);
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$config = \SimpleSAML\Configuration::getInstance();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
?>

<?php $this->includeAtTemplateBase('includes/header_uhu.php');?>


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

<div class="row">
    <div class="col-md-6 col-md-offset-3">
			<form method="post"  role="form" action="newUser.php">
			<?php
            if (isset($this->data['RelayState'])) {
                echo('<input type="hidden" name="RelayState" value="' . $this->data['RelayState'] . '" />');
            }
            ?>
			<div class="form-group">
			    <label for="dni"><?php echo $this->t('s1_para1_label'); ?></label>
                <input autofocus  required placeholder="<?php echo $this->t('s1_para1'); ?>" type="text" size="45" name="dni" class="form-control" id="dni" value="<?php echo isset($this->data['dni'])? htmlspecialchars($this->data['dni']) : '';?>">
                <a href="help.php"><?php echo $this->t('lpw_noinformation'); ?> </a>
			</div>

			<?php
            if ($uregconf->getString('enable_captcha') == 'true') {
            ?>
				<div class="form-group">
					<label for="captcha_code"><?php echo $this->t('captchalabel'); ?></label>
					<input required type="text" name="captcha_code" placeholder="<?php echo $this->t('captchaintro'); ?>" class="form-control" id="captcha_code">
					<a href="#" onclick="document.getElementById('captcha').src = 'resources/securimage/securimage_show.php?' + Math.random(); return false"><?php echo $this->t('captchanewimage'); ?></a><br>
					<img id="captcha" src="resources/securimage/securimage_show.php" alt="CAPTCHA Image" />
				</div>
			<?php
            }
            ?>

			<button class="btn btn-lg btn-primary btn-block" type="submit" name="save" value="<?php echo $this->t('submit_mail'); ?>"> <?php echo $this->t('submit_mail'); ?> </button>
      </form>
	</div>
</div>

<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

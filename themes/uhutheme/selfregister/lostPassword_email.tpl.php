<?php
$config = \SimpleSAML\Configuration::getInstance();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';

$this->data['header'] = $this->t('lpw_head');

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

<div class="row">
    <div class="col-md-6 col-md-offset-3">
      <form role="form" method="post" action="lostPassword.php" id="forgetpwd_form">
        <div class="form-group">
          <label for="emailreg"><?php echo $this->t('lpw_uid_field'); ?></label>
          <input required autofocus type="text" name="emailreg" id="user" placeholder="<?php echo $this->t('lpw_para1'); ?>" class="form-control" id="emailreg">
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
        <input type="hidden" name="passToken" id="passToken" value="">
        <input type="hidden" name="passport_ph" id="passport_ph" value="">
        <button class="btn btn-lg btn-primary btn-block" id="submit_button" type="submit"><?php echo $this->t('submit_mail'); ?></button>
    </form>
  </div>
</div>

<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

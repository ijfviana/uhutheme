<?php
$this->data['header'] = $this->t('lpw_head', $this->data['systemName']);
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$config = \SimpleSAML\Configuration::getInstance();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
?>

<?php $this->includeAtTemplateBase('includes/header_uhu.php'); ?>

<div style="margin: 1em">
	  <p><?php echo $this->t('lpw_complete_para1') ?></p>	  
</div>

<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

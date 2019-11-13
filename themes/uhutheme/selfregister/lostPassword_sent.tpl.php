<?php
$this->data['header'] = $this->t('lpw_check_email', $this->data['systemName']);
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$config = \SimpleSAML\Configuration::getInstance();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
?>
<?php echo "<!--   -->"; ?>
<?php $this->includeAtTemplateBase('includes/header_uhu.php');?>

<div style="margin: 1em">    
    <p><?php echo $this->t('lpw_check_email_explain', ['%VAR1%' => $this->data['email']]); ?></p>
</div>

<p> <a href="help.php"><?php echo $this->t('lpw_dont_have_email'); ?></a><p>

<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

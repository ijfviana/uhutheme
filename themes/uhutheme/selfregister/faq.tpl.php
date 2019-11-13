<?php
$this->data['header'] = /*$this->t('s1_head', $this->data['systemName'])*/ "Preguntas frecuentes";
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$config = \SimpleSAML\Configuration::getInstance();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
?>

<?php $this->includeAtTemplateBase('includes/header_uhu.php'); ?>


<?php
$faqs = $this->data['faq'];
foreach ($faqs as $label => $body) {
    echo '<div class="faq">';
    echo '<h4>'. $label . '</h2>';
    echo '<p>' . $body . '</p><br>';
    echo '</div>';
}

 $this->includeAtTemplateBase('includes/footer_uhu.php');

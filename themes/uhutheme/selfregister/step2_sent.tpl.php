<?php
$this->data['header'] = $this->t('s1_head', $this->data['systemName']);
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$this->includeAtTemplateBase('includes/header_uhu.php');
?>

<div style="margin: 1em">
	  <p>
<?php
echo $this->t(
    's2_para1',
    [
        '%EMAIL%' => $this->data['email']
    ]
);
?></p>
</div>

<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

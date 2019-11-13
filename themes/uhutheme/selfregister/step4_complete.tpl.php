<?php
$this->data['header'] = $this->t('s1_head', $this->data['systemName']);
$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$this->includeAtTemplateBase('includes/header_uhu.php');
?>

<div style="margin: 1em">
	<p><?php
        echo $this->t(
            'new_complete_para1',
            [
                '%SNAME%' => $this->data['systemName'],
                '%SUID%' => $this->data['uid'],
                '%SPASS%' => $this->data['pass']
            ]
        ); ?></p>
	  <ul>
	    <li><a href="lostPassword.php"><?php echo $this->t('link_lostpw'); ?></li>
	  </ul>
</div>

<?php $this->includeAtTemplateBase('includes/footer_uhu.php');

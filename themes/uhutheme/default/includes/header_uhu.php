<?php


/**
 * Support the htmlinject hook, which allows modules to change header, pre and post body on all pages.
 */
$this->data['htmlinject'] = [
        'htmlContentPre' => [],
        'htmlContentPost' => [],
        'htmlContentHead' => [],
];


$jquery = [];
if (array_key_exists('jquery', $this->data)) {
    $jquery = $this->data['jquery'];
}
if (array_key_exists('pageid', $this->data)) {
    $hookinfo = [
            'pre' => &$this->data['htmlinject']['htmlContentPre'],
            'post' => &$this->data['htmlinject']['htmlContentPost'],
            'head' => &$this->data['htmlinject']['htmlContentHead'],
            'jquery' => &$jquery,
            'page' => $this->data['pageid']
    ];

    \SimpleSAML\Module::callHooks('htmlinject', $hookinfo);
}
// - o - o - o - o - o - o - o - o - o - o - o - o -

/**
 * Do not allow to frame simpleSAMLphp pages from another location.
 * This prevents clickjacking attacks in modern browsers.
 *
 * If you don't want any framing at all you can even change this to
 * 'DENY', or comment it out if you actually want to allow foreign
 * sites to put simpleSAMLphp in a frame. The latter is however
 * probably not a good security practice.
 */
header('X-Frame-Options: SAMEORIGIN');

?><!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0" />
<script type="text/javascript" src="/<?php echo $this->data['baseurlpath']; ?>resources/script.js"></script>
<title><?php
if (array_key_exists('header', $this->data)) {
        echo $this->data['header'];
} else {
        echo 'simpleSAMLphp';
}
?></title>

  <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="<?php echo \SimpleSAML\Module::getModuleURL('uhutheme/libs/css/default.css'); ?>" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>


<?php

if (!empty($this->data['htmlinject']['htmlContentHead'])) {
    foreach ($this->data['htmlinject']['htmlContentHead'] as $c) {
        echo $c;
    }
}
?>
        <meta name="robots" content="noindex, nofollow" />


<?php
if (array_key_exists('head', $this->data)) {
    echo '<!-- head -->' . $this->data['head'] . '<!-- /head -->';
}
?>
</head>
<?php
$onLoad = '';
if (array_key_exists('autofocus', $this->data)) {
    $onLoad .= 'SimpleSAML_focus(\'' . $this->data['autofocus'] . '\');';
}
if (isset($this->data['onLoad'])) {
    $onLoad .= $this->data['onLoad'];
}

if ($onLoad !== '') {
    $onLoad = ' onload="' . $onLoad . '"';
}
?>
<body<?php echo $onLoad; ?>>

<div id="wrap">
    <div id="header" align="center">
            <div class="col-sm-10 col-md-10 vcenterbottom" >
                <a href="/<?php echo $this->data['baseurlpath'];?>" ><img alt="Universidad de Huelva" id="profile-img" class="profile-img-card" style="text-align: left;" src="<?php echo \SimpleSAML\Module::getModuleURL('uhutheme/img/uhu_logo.png')?>"/> <br/> <div id="miaccount"> Mi cuenta </div></a>
            </div>
    </div>
    <div id="content">
        <div class="col-sm-10 col-md-10 col-md-offset-1">
            <!--<div class="title-item dis_bot35 t_c" style="text-align: center; border-bottom: 1px solid #f2f2f2;" >
                    <h4 class="title-big" style="font-size: 20px; color: #333; line-height: 1.5; font-weight: 400; text-transform:uppercase;">
                            <?php #echo (isset($this->data['header']) ? $this->data['header'] : 'simpleSAMLphp'); ?>
                    </h4>
            </div>
            -->
            <div id="regbox" style="line-height: 20px;">

                <?php
                if (!empty($this->data['htmlinject']['htmlContentPre'])) {
                    foreach ($this->data['htmlinject']['htmlContentPre'] as $c) {
                        echo $c;
                    }
                }

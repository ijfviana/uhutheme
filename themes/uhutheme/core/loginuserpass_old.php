<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo SimpleSAML_Module::getModuleURL('uhutheme/icon.ico'); ?>">


<title><?php


// Needed due includeLanguageFile funtion only works with the base dictionaries
$file = SimpleSAML_Module::getModuleDir('uhutheme') . '/dictionaries/uhutheme';
$lang = $this->readDictionaryJSON($file);
$this->langtext = array_merge($this->langtext, $lang);

if(array_key_exists('header', $this->data)) {
        echo $this->data['header'];
} else {
        echo 'UHU- Universidad de Huelva';
}

$links  =array();
SimpleSAML_Module::callHooks('loginuserpass', $this->data['links']);


?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <!-- Font-Awesome -->
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Custom styles for this template -->
    <link href="<?php echo SimpleSAML_Module::getModuleURL('uhutheme/libs/css/default.css'); ?>" rel="stylesheet">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

</head>

<?php
    $authStateId = $_REQUEST['AuthState'];
    // Retrieve the authentication state.
    $state = SimpleSAML_Auth_State::loadState($authStateId, sspmod_core_Auth_UserPassBase::STAGEID);
    //var_dump($state['SPMetadata']);
    if (array_key_exists('SPMetadata', $state)){
        $SPentityID                = $state['SPMetadata']['entityid'];
    //    $SPName                    = $state['SPMetadata']['name']['en'];
    //    $SPDisplayName             = $state['SPMetadata']['UIInfo']['DisplayName']['en'];
    //    $SPDescription             = $state['SPMetadata']['UIInfo']['Description']['en'];
    //    $SPOrganizationName        = $state['SPMetadata']['OrganizationName']['en'];
    //    $SPOrganizationDisplayName = $state['SPMetadata']['OrganizationDisplayName']['en'];
    //    $SPOrganizationURL         = $state['SPMetadata']['OrganizationURL']['en'];
        $SPinfo = $SPentityID;
        if (array_key_exists('en', $state['SPMetadata']['UIInfo']['DisplayName'])) {
            $SPinfo = $state['SPMetadata']['UIInfo']['DisplayName']['en'];
        }
        elseif (array_key_exists('en', $state['SPMetadata']['OrganizationName'])){
            $SPinfo = $state['SPMetadata']['OrganizationName']['en'];
        }
        elseif (array_key_exists('en', $state['SPMetadata']['OrganizationDisplayName'])){
            $SPinfo = $state['SPMetadata']['OrganizationDisplayName']['en'];
        }
        elseif (array_key_exists('en', $state['SPMetadata']['name'])){
            $SPinfo = $state['SPMetadata']['name']['en'];
        }
    }
    else {    $SPinfo = $this->t('{uhutheme:uhutheme:sp_header}');}
?>

<body class="login">
    <div class="container" style="margin-top:40px">
        <div class=row>
            <div class="col-sm-12 col-md-12  text-center">
                <img id="profile-img" class="profile-img-card" src="<?php echo SimpleSAML_Module::getModuleURL('uhutheme/uhu_logo.png')?>"/>
            </div>

            <div class="col-sm-12 col-md12 text-center" style="margin-top:35px; margin-bottom:35px;">
                <h2><?php echo $this->t('{uhutheme:uhutheme:signin_header}') ?> </h2>
                <h3><?php echo "$SPinfo";?></h3>
            </div>
        </div>
        <div class="row">
            <div class="container">
                <div class="card card-container">
                    <form class="form-signin">

                 <?php
if ($this->data['forceUsername']) {
  echo '<input placeholder= " '.  $this->t('{login:username}') . '" readonly type="text" class="form-control" id="username"  value=".'. htmlspecialchars($this->data['username']) . '" required autofocus name="username"/>';

} else {
    echo '<input placeholder="'.  $this->t('{login:username}') . '"" type="text" class="form-control" id="username"  value="'. htmlspecialchars($this->data['username']) . '" required autofocus name="username"/>';

}
?>
                        <input class="form-control" placeholder="<?php echo $this->t('{login:password}')?>"  id="password" name="password" type="password" value="">
 <?php
                    if ($this->data['errorcode'] !== NULL) {
                    ?>
                        <div class="alert alert-danger">
                            <i class="fa fa-exclamation-triangle"></i> <?php echo $this->t('{errors:title_' . $this->data['errorcode'] . '}') ; ?>
                        </div>
                    <?php
                    }
                    ?>

                    <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"><?php echo $this->t('{login:login_button}'); ?></button>
                    <div id="links" align="center">
                    <?php
                            if(!empty($this->data['links'])) {
                                foreach($this->data['links']['auth'] AS $l) {
                                     $textarray[] = '<a href="' . htmlspecialchars($l['href']) . '">' . htmlspecialchars($this->t($l['text'])) . '</a> ';
                                }
                            }

                            echo join(" | ",$textarray);

                        ?>
                    </div>
                     <?php
                    foreach ($this->data['stateparams'] as $name => $value) {
                    echo('<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />');
                    }
                    ?>
                    </form><!-- /form -->
                </div><!-- /card-container -->
            </div>
        </div>

        <div class="row">
            <div class="col-md-12" style="text-align: center; padding-bottom: 20px; position: absolute; bottom: 0px; left: 0px; width: 100%;" >
                <h5 align="middle"">
                    <?php
                    $languages = $this->getLanguageList();
                    $langnames = $langnames = array(
                                                'no' => 'Bokmål', // Norwegian Bokmål
                                                'nn' => 'Nynorsk', // Norwegian Nynorsk
                                                'se' => 'Sámegiella', // Northern Sami
                                                'sam' => 'Åarjelh-saemien giele', // Southern Sami
                                                'da' => 'Dansk', // Danish
                                                'en' => 'English',
                                                'de' => 'Deutsch', // German
                                                'sv' => 'Svenska', // Swedish
                                                'fi' => 'Suomeksi', // Finnish
                                                'es' => 'Español', // Spanish
                                                'fr' => 'Français', // French
                                                'it' => 'Italiano', // Italian
                                                'nl' => 'Nederlands', // Dutch
                                                'lb' => 'Lëtzebuergesch', // Luxembourgish
                                                'cs' => 'Čeština', // Czech
                                                'sl' => 'Slovenščina', // Slovensk
                                                'lt' => 'Lietuvių kalba', // Lithuanian
                                                'hr' => 'Hrvatski', // Croatian
                                                'hu' => 'Magyar', // Hungarian
                                                'pl' => 'Język polski', // Polish
                                                'pt' => 'Português', // Portuguese
                                                'pt-br' => 'Português brasileiro', // Portuguese
                                                'ru' => 'русский язык', // Russian
                                                'et' => 'eesti keel', // Estonian
                                                'tr' => 'Türkçe', // Turkish
                                                'el' => 'ελληνικά', // Greek
                                                'ja' => '日本語', // Japanese
                                                'zh' => '简体中文', // Chinese (simplified)
                                                'zh-tw' => '繁體中文', // Chinese (traditional)
                                                'ar' => 'العربية', // Arabic
                                                'fa' => 'پارسی', // Persian
                                                'ur' => 'اردو', // Urdu
                                                'he' => 'עִבְרִית', // Hebrew
                                                'id' => 'Bahasa Indonesia', // Indonesian
                                                'sr' => 'Srpski', // Serbian
                                                'lv' => 'Latviešu', // Latvian
                                                'ro' => 'Românește', // Romanian
                                                'eu' => 'Euskara', // Basque
                        );

                    $textarray = array();
                    foreach ($languages AS $lang => $current) {
                        $lang = strtolower($lang);
                        if ($current) {
                            $textarray[] = $langnames[$lang] ;
                        } else {
                            $textarray[] = '<a href="' . htmlspecialchars(SimpleSAML_Utilities::addURLparameter(SimpleSAML_Utilities::selfURL(), array('language' => $lang))) . '">' .
                            $langnames[$lang] . '</a>';
                        }
                    }
                    echo join(" | ",$textarray);
                    ?>

                    | FAQ</h5>
                <h5 align="middle"> Universidad de Huelva, Todos los Derechos Reservados - Dr. Cantero Cuadrado, 6. 21071 Huelva Teléfonos: +34 (959) 21800</h5>
            </div>
        </div> <!-- /row -->
    </div> <!-- /container -->
</body>
</html>

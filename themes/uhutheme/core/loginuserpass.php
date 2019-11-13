<?php

if (array_key_exists('SPMetadata', $this->data) && !empty($this->data['SPMetadata'])) {
    $spMetadata = $this->data['SPMetadata'];
    $SPentityID = $spMetadata['entityid'];
    $SPinfo = $SPentityID;

    if (array_key_exists('UIInfo', $spMetadata) &&
        array_key_exists('en', $spMetadata['UIInfo']['DisplayName'])) {
            $SPinfo = $spMetadata['UIInfo']['DisplayName']['en'];
    } elseif (array_key_exists('en', $spMetadata['OrganizationName'])) {
        $SPinfo = $spMetadata['OrganizationName']['en'];
    } elseif (array_key_exists('en', $spMetadata['OrganizationDisplayName'])) {
        $SPinfo = $spMetadata['OrganizationDisplayName']['en'];
    } elseif (array_key_exists('en', $spMetadata['name'])) {
        $SPinfo = $spMetadata['name']['en'];
    }
} else {
    $SPinfo = $this->t('{uhutheme:uhutheme:sp_header}');
}

$this->data['header'] =  $this->t('{uhutheme:uhutheme:signin_header}') . '<br>' . $SPinfo;

$this->data['head'] = '<link rel="stylesheet" href="resources/umesg.css" type="text/css">';
$config = \SimpleSAML\Configuration::getInstance();
//print_r($config['production']);exit();
$uregconf = \SimpleSAML\Configuration::getConfig('module_selfregister.php');
$links  = [];
\SimpleSAML\Module::callHooks('loginuserpass', $this->data['links']);

$this->includeAtTemplateBase('includes/header_uhu.php');
if ($this->data['errorcode'] !== null) {
?>
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>

        <strong>
        <?php
            echo htmlspecialchars(
                $this->t(
                    $this->data['errorcodes']['title'][$this->data['errorcode']],
                    $this->data['errorparams']
                )
            );
        ?>
        </strong>
        <?php
        if ($config->getBoolean('showerrors', false)) {
            echo '<br><br>'.htmlspecialchars(
                $this->t(
                    $this->data['errorcodes']['descr'][$this->data['errorcode']],
                    $this->data['errorparams']
                )
            );
        }
        ?>
    </div>
<?php
}
?>
    <form class="form-signin" action="?" method="post" name="f">
        <input class="form-control" id="username" <?php echo ($this->data['forceUsername']) ? 'disabled="disabled"' : ''; ?>
                        type="text" name="username"<?php echo $this->data['forceUsername'] ? '' : ' tabindex="1"'; ?>
                        value="<?php echo htmlspecialchars($this->data['username']); ?>" />
            <?php
            if ($this->data['rememberUsernameEnabled'] && !$this->data['forceUsername']) {
                // display the "remember my username" checkbox
            ?>

                <input class="form-control" type="checkbox" id="remember_username" tabindex="4"
                            <?php echo ($this->data['rememberUsernameChecked']) ? 'checked="checked"' : ''; ?>
                            name="remember_username" value="Yes" />
                    <small><?php echo $this->t('{login:remember_username}'); ?></small>
            <?php
            }
            ?>
            <?php
            if ($this->data['rememberUsernameEnabled'] && !$this->data['forceUsername']) {
                // display the "remember my username" checkbox
            ?>
                <input class="form-control" type="checkbox" id="remember_username" tabindex="4"
                        <?php echo ($this->data['rememberUsernameChecked']) ? 'checked="checked"' : ''; ?>
                        name="remember_username" value="Yes" />
                    <small><?php echo $this->t('{login:remember_username}'); ?></small>                
            <?php
            }
            ?>
            <input class="form-control" id="password" type="password" tabindex="2" name="password" /></td>
            <?php
            if ($this->data['rememberMeEnabled']) {
                // display the remember me checkbox (keep me logged in)
            ?>
                <input type="checkbox" id="remember_me" tabindex="5"
                        <?php echo ($this->data['rememberMeChecked']) ? 'checked="checked"' : ''; ?>
                        name="remember_me" value="Yes" />
                    <small><?php echo $this->t('{login:remember_me}'); ?></small>
            <?php
            }
            ?>
            <?php
            if ($this->data['rememberMeEnabled']) {
                // display the remember me checkbox (keep me logged in)
            ?>
                    <input type="checkbox" id="remember_me" tabindex="5"
                        <?php echo ($this->data['rememberMeChecked']) ? 'checked="checked"' : ''; ?>
                        name="remember_me" value="Yes" />
                    <small><?php echo $this->t('{login:remember_me}'); ?></small>
            <?php
            }
            ?>            
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit"><?php echo $this->t('{login:login_button}'); ?></button>
        <input type="hidden" id="processing_trans" value="<?php echo $this->t('{login:processing}'); ?>" />
        <?php
        foreach ($this->data['stateparams'] as $name => $value) {
            echo '<input type="hidden" name="'.htmlspecialchars($name).'" value="'.htmlspecialchars($value).'" />';
        }
        ?>
    </form>
<?php
if (!empty($this->data['links'])) {
    echo '<ul class="links" style="margin-top: 2em">';
    foreach ($this->data['links'] as $l) {
        echo '<li><a href="'.htmlspecialchars($l['href']).'">'.htmlspecialchars($this->t($l['text'])).'</a></li>';
    }
    echo '</ul>';
}

$this->includeAtTemplateBase('includes/footer_uhu.php');

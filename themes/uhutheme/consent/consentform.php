<?php
/**
 * Template form for giving consent.
 *
 * Parameters:
 * - 'srcMetadata': Metadata/configuration for the source.
 * - 'dstMetadata': Metadata/configuration for the destination.
 * - 'yesTarget': Target URL for the yes-button. This URL will receive a POST request.
 * - 'yesData': Parameters which should be included in the yes-request.
 * - 'noTarget': Target URL for the no-button. This URL will receive a GET request.
 * - 'noData': Parameters which should be included in the no-request.
 * - 'attributes': The attributes which are about to be released.
 * - 'sppp': URL to the privacy policy of the destination, or FALSE.
 *
 * @package simpleSAMLphp
 */

assert(is_array($this->data["srcMetadata"]));
assert(is_array($this->data["dstMetadata"]));
assert(is_string($this->data["yesTarget"]));
assert(is_array($this->data["yesData"]));
assert(is_string($this->data["noTarget"]));
assert(is_array($this->data["noData"]));
assert(is_array($this->data["attributes"]));
assert(is_array($this->data["hiddenAttributes"]));
assert($this->data["sppp"] === false || is_string($this->data["sppp"]));

?>

  <section id="header_consent">
    <div class="container">
     <div class="row">
      <div class="col-xs-12 col-sm-6 col-md-6 pad-tb-20" id="logo">
        <a href="/<?php echo $this->data['baseurlpath'];?>" ><img alt="Universidad de Huelva" id="profile-img" class="profile-img-card" style="text-align: left;" src="<?php echo \SimpleSAML\Module::getModuleURL('uhutheme/img/uhu_logo.png')?>"/></a>
      </div>
      <div id="miaccount" class="col-xs-12 col-sm-6 col-md-6 pad-tb-20"> Mi cuenta:<br/>
      	<span style="font-weight:400;"> 
      		<?php 
      		
      		if (array_key_exists('eduPersonPrincipalName', $this->data["attributes"])) {
	      		echo ($this->data["attributes"]["eduPersonPrincipalName"][0]); 
			} elseif (array_key_exists('eduPersonTargetedID', $this->data["attributes"])) {
	      		echo ($this->data["attributes"]["eduPersonTargetedID"][0]); 
	      	} elseif (array_key_exists('schacPersonalUniqueCode', $this->data["attributes"])) {
	      		echo ($this->data["attributes"]["schacPersonalUniqueCode"][0]); 
	      	} elseif (array_key_exists('schacPersonalUniqueID', $this->data["attributes"])) {
	      		echo ($this->data["attributes"]["schacPersonalUniqueID"][0]); 
			} else {
			    echo "&nbsp";
			}			
      		?>
      	</span>
      </div>
    </div>
  </div>
</section>

<section id="content_consent">
  <div class="container">
   <div class="row">
     <div id="regbox" class="textcenter">

<?php
if (!empty($this->data['htmlinject']['htmlContentPre'])) {
    foreach ($this->data['htmlinject']['htmlContentPre'] as $c) {
        echo $c;
    }
}

// Parse parameters
if (array_key_exists('name', $this->data['srcMetadata'])) {
    $srcName = $this->data['srcMetadata']['name'];
} elseif (array_key_exists('OrganizationDisplayName', $this->data['srcMetadata'])) {
    $srcName = $this->data['srcMetadata']['OrganizationDisplayName'];
} else {
    $srcName = $this->data['srcMetadata']['entityid'];
}

if (is_array($srcName)) {
    $srcName = $this->t($srcName);
}

if (array_key_exists('name', $this->data['dstMetadata'])) {
    $dstName = $this->data['dstMetadata']['name'];
} elseif (array_key_exists('OrganizationDisplayName', $this->data['dstMetadata'])) {
    $dstName = $this->data['dstMetadata']['OrganizationDisplayName'];
} else {
    $dstName = $this->data['dstMetadata']['entityid'];
}

if (is_array($dstName)) {
    $dstName = $this->t($dstName);
}

$srcName = htmlspecialchars($srcName);
$dstName = htmlspecialchars($dstName);

$attributes = $this->data['attributes']; //atributos del usuario
$privacypolicy = null;
if (isset($this->data['dstMetadata']['privacypolicy'])) {
	$privacypolicy = $this->data['dstMetadata']['privacypolicy']; //politica privacidad metadato
}

$this->data['header'] = $this->t('{consent:consent:consent_header}');
$this->data['head']  = '<link rel="stylesheet" type="text/css" href="/' .
    $this->data['baseurlpath'] . 'module.php/consent/style.css" /> '."\n";

$this->includeAtTemplateBase('includes/header_uhu_consent.php');
?>

<!-- texto introductorio que solicita los datos -->
<p class="marginTop40">
    <?php
    echo $this->t(
        '{uhutheme:consent:consent_accept}',
        ['SPNAME' => $dstName, 'IDPNAME' => $srcName]
    );

    if (array_key_exists('descr_purpose', $this->data['dstMetadata'])) {
        echo '</p><p>' . $this->t(
            '{consent:consent:consent_purpose}',
            [
                'SPNAME' => $dstName,
                'SPDESC' => $this->getTranslation(
                    \SimpleSAML\Utils\Arrays::arrayize(
                        $this->data['dstMetadata']['descr_purpose'],
                        'en'
                    )
                ),
            ]
        );
    }
    ?>
</p>


<?php
/*if ($this->data['sppp'] !== false) {
    echo "<p>" . htmlspecialchars($this->t('{consent:consent:consent_privacypolicy}')) . " ";
    echo "<a target='_blank' href='" . htmlspecialchars($this->data['sppp']) . "'>" . $dstName . "</a>";
    echo "</p>";
}*/

/**
 * Recursiv attribute array listing function
 *
 * @param array                     $table_through Array of attributes to be presented
 *
 * @return string HTML representation of the attributes
 */
function throughArray($table_through, $str, $name, $parentStr, $value, $t, $title_table, $collapse)
{
  //BEGIN accordion
    $str .=
    '<div class="panel panel-default">
      <div class="panel-heading">
        <a data-toggle="collapse" data-parent="#accordion" href="#' . $collapse .'" class="collapsed">';

    $str .= $title_table . ' <i class="fa fa-caret-down" aria-hidden="true"></i>';

    $str .=
        '</a>
      </div>
      <div id="'. $collapse . '" class="panel-collapse collapse">
        <div class="panel-body">';

    foreach ($table_through as $name => $value) {
        $nameraw = $name;
        $name = $t->getAttributeTranslation($parentStr . $nameraw);

        $str .= "\n" . '<p class="attrname">' . htmlspecialchars($name) . ': </p>';

        $isHidden = in_array($nameraw, $t->data['hiddenAttributes'], true);
        if ($isHidden) {
            $hiddenId = \SimpleSAML\Utils\Random::generateID();
            $str .= '<div class="attrvalue borderBottom" style="display: none;" id="hidden_' . $hiddenId . '">';
        } else {
            $str .= '<div class="attrvalue borderBottom">';
        }

        if (sizeof($value) > 1) {
            // We hawe several values
            $str .= '<ul class="no_list">';
            foreach ($value as $listitem) {
                if ($nameraw === 'jpegPhoto') {
                    $str .= '<li><img src="data:image/jpeg;base64,' .
                      htmlspecialchars($listitem) .
                      '" alt="User photo" /></li>';
                } else {
                    $str .= '<li>' . htmlspecialchars($listitem) . '</li>';
                }
            }
                  $str .= '</ul>';
        } elseif (isset($value[0])) {
            // We hawe only one value
            if ($nameraw === 'jpegPhoto') {
                $str .= '<img src="data:image/jpeg;base64,' .
                  htmlspecialchars($value[0]) .
                          '" alt="User photo" />';
            } else {
                $str .= htmlspecialchars($value[0]);
            }
        }
        // end of if multivalue
        $str .= '</div>';
    }
    // end foreach

    $str .= '</div> </div> </div> '; //END accordion

    return $str;
}

/**
 * Recursiv attribute array listing function
 *
 * @param \SimpleSAML\XHTML\Template $t          Template object
 * @param array                     $attributes Attributes to be presented
 * @param string                    $nameParent Name of parent element
 *
 * @return string HTML representation of the attributes
 */
function uhu_present_attributes($t, $attributes, $nameParent)
{
    $config = \SimpleSAML\Configuration::getInstance();
    $uhuconfig = \SimpleSAML\Configuration::getConfig('module_uhutheme.php');

    //array para Caracteristicas personales del SSO
    //$personal = ['cn', 'displayName', 'gn', 'givenName', 'sn', 'schacSn1', 'schacSn2', 'schacgender'];
    $personal = $uhuconfig->getValue('personal');
    $personal_toShow = [];

    //array para Contacto / Localizacion del SSO
    //$contact = array('irismailmainaddress','mail','organizationName','o','organizationalUnitName','ou');
    $contact = $uhuconfig->getValue('contact');
    $contact_toShow = [];

    //array para Datos laborales del SSO
    //$occupational = array('eduPersonAffiliation','eduPersonPrimaryAffiliation','employeeNumber);
    $occupational = $uhuconfig->getValue('occupational');
    $occupational_toShow = [];

    //array para Identidicadores de enlace del SSO
    //$identity = array('schacpersonaluniqueid','schacPersonalUniqueCode','uid','eduPersonPrincipalName);
    $identity = $uhuconfig->getValue('identity');
    $identity_toShow = [];

    //array para Autorizacion / Derechos de acceso del SSO
    //$auth = array('schacuserstatus','irisUserEntitlement);
    $auth = $uhuconfig->getValue('auth');
    $auth_toShow = [];

    //array para Atributos sobrantes del selecsource
    $others = [];
    $summary = 'summary="' . $t->t('{consent:consent:table_summary}') . '"';
    $tabla_valores = []; //almacena los valores de los atributos que se van a mostrar
    $table_show = 0;// para saber si ya ha mostrado esos valores o no

    foreach ($attributes as $name => $value) {
        $tabla_valores[0] = $value;
        if (in_array($name, $personal)) {
            $personal_toShow[$name] = $tabla_valores[0];
        } else if (in_array($name, $contact)) {
            $contact_toShow[$name] = $tabla_valores[0];
        } else if (in_array($name, $occupational)) {
            $occupational_toShow[$name] = $tabla_valores[0];
        } else if (in_array($name, $identity)) {
            $identity_toShow[$name] = $tabla_valores[0];
        } else if (in_array($name, $auth)) {
            $auth_toShow[$name] = $tabla_valores[0];
        } else {
            $others[$name] = $tabla_valores[0];
        }
    }


    //BEGIN div inicio atributos
    if (strlen($nameParent) > 0) {
        $parentStr = strtolower($nameParent) . '_';
        $str = '<div class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 attributes marginBottom40" ' . $summary . '> <div class="panel-group accordion-style2" id="accordion">';
    } else {
        $parentStr = '';
        $str = '<div id="table_with_attributes" class="col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 attributes marginTop40 marginBottom40" '. $summary .'> <div class="panel-group accordion-style2" id="accordion">';
    }

    //Muestra valores de personal_info
    if (!empty($personal_toShow)) {
        $title_table = $t->t('{uhutheme:consent:personal_info}');
        $collapse = 'collapsePersonal';
        $str2 = throughArray($personal_toShow, $str, $name, $parentStr, $value, $t, $title_table, $collapse);

    }
    // Muestra valores de contacto/localización
    if (!empty($contact_toShow)) {
        $title_table = $t->t('{uhutheme:consent:contact_info}');
        $collapse = 'collapseContact';
        $str2 = throughArray($contact_toShow, $str2, $name, $parentStr, $value, $t, $title_table, $collapse);
    }
    // Muestra valores de contacto/localización
    if (!empty($occupational_toShow)) {
        $title_table = $t->t('{uhutheme:consent:occupational_info}');
        $collapse = 'collapseOccupational';
        $str2 = throughArray($occupational_toShow, $str2, $name, $parentStr, $value, $t, $title_table, $collapse);
    }
    // Muestra datos de identidad
    if (!empty($identity_toShow)) {
        $title_table = $t->t('{uhutheme:consent:identity_info}');
        $collapse = 'collapseIdentity';
        $str2 = throughArray($identity_toShow, $str2, $name, $parentStr, $value, $t, $title_table, $collapse);
    }
    // Muestra datos de gestión
    if (!empty($auth_toShow)) {
        $title_table = $t->t('{uhutheme:consent:auth_info}');
        $collapse = 'collapseAuth';
        $str2 = throughArray($auth_toShow, $str2, $name, $parentStr, $value, $t, $title_table, $collapse);
    }
    // Muestra otros datos					
    if (!empty($others)) {
        $title_table = $t->t('{uhutheme:consent:others_info}');
        $collapse = 'collapseOthers';
        $str2 = throughArray($others, $str2, $name, $parentStr, $value, $t, $title_table, $collapse);
    }

    $str2 .= '</div>'; //END accordion

    $str2 .= isset($attributes)? '</div>':''; // END div inicio atributos

    return $str2;
}

/* atributos --> mirar la funcion de arriba */
echo(uhu_present_attributes($this, $attributes, ''));

/* BEGIN Acepta las condiciones: si o no */
?>
<div class="marginTop40 clearCol"></div>
<div class="borderTopDouble col-md-8 col-md-offset-2">
  <!-- texto informativo -->
  <div class="textcenter marginTop40 col-md-8 col-md-offset-2">
    <p>
    <?php
    if ($this->data['usestorage'] && $privacypolicy) {
        echo $this->t('{uhutheme:consent:text_accept}') . "<a href=". $privacypolicy . " target=_blank >" . $this->t('{uhutheme:consent:text_accept_2}') . "</a>";
    } else if ($this->data['usestorage'] && !$privacypolicy) {
        echo $this->t('{uhutheme:consent:text_accept_withoutpolity}');
    }
    ?>
    </p>
  </div>
  <div class="clearCol"></div>
  <!-- formulario sí o no -->
  <div class="textcenter col-md-8 col-md-offset-2 pad-tb-10">
    <!-- Denegar envio -->
    <form style="display: inline; margin-left: .5em;" action="<?php echo htmlspecialchars($this->data['noTarget']); ?>" method="get">
        <?php
        foreach ($this->data['noData'] as $name => $value) {
            echo('<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />');
        } ?>
      <input class="btn_noconsent" type="submit" onclick="showLoad()" style="display: inline" name="no" id="nobutton" value="<?php echo htmlspecialchars($this->t('{uhutheme:consent:disallow}')) ?>" />
    </form>
    <!-- Permitir el envio de datos -->
    <form style="display: inline; margin: 0px; padding: 0px" action="<?php echo htmlspecialchars($this->data['yesTarget']); ?>">
      <input class="btn_consent" type="submit" onclick="showLoad()" name="yes" id="yesbutton" value="<?php echo htmlspecialchars($this->t('{uhutheme:consent:allow}')) ?>" />
      <p class="small_text">
        <?php
        if ($this->data['usestorage']) {
            $checked = ($this->data['checked'] ? 'checked="checked"' : '');
            echo '<input type="checkbox" name="saveconsent" ' . $checked . ' value="1" /> ' . $this->t('{consent:consent:remember}');
        }

        // Embed hidden fields...
        foreach ($this->data['yesData'] as $name => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars($value) . '" />';
        }
        ?>
      </p>


    </form>


  </div>
  <div class="clearCol"></div>
</div>
<div class="clearCol"></div>
<?php
/* END Acepta las condiciones: si o no */

$this->includeAtTemplateBase('includes/footer_uhu.php');

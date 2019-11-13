
<?php
#$this->data['header'] = $this->t('{multiauth:multiauth:select_source_header}');
$this->includeAtTemplateBase('includes/header_uhu.php');
?>

<!--<p align="center" class="marginBottom40">-<?php #echo $this->t('{multiauth:multiauth:select_source_text}'); ?></p>-->

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="get" style="">
	<input type="hidden" name="AuthState" value="<?php echo htmlspecialchars($this->data['authstate']); ?>" />

	<ul class="list-group">
	<div class="col-md-12 box_auth">
		<?php

        echo '<li class="marginTop40 col-md-12 uhu titleSource textcenter"> ' .$this->t('{uhutheme:uhutheme:select_source_header}'). '</p> </li>';

        foreach ($this->data['sources'] as $source) {
            $variable = htmlspecialchars($source['source']);
            $largo = strlen($variable); #capturamos el largo de la cadena
            $subcadena = substr($variable, $largo-4); #capturamos los 4 ultimos caracteres de la cadena

            if ($subcadena == "-uhu") {
                echo '<li class="list-group-item' . htmlspecialchars($source['css_class']) . ' authsourcem col-md-4 uhu">';
                if ($source['source'] === $this->data['preferred']) {
                    $autofocus = ' autofocus="autofocus"';
                } else {
                    $autofocus = '';
                }
                $name = 'src-' . base64_encode($source['source']);

                echo '<button class="btn btn-default" type="submit" name="' . htmlspecialchars($name) . '"' . $autofocus . ' ' .
                    'id="button-' . htmlspecialchars($source['source']) . '" ' .
                    'value="' . htmlspecialchars($source['text']) . '" >
            		<img src="'. \SimpleSAML\Module::getModuleURL('uhutheme/img/authsources/'. htmlspecialchars($source['source'].'.png')).'" </img>
            		</br> <br/>' . htmlspecialchars($source['text']). ' </button>';

                echo '</li>';
            }
        }?>
</div>

<div class="col-md-12 marginTop40 box_auth">
<?php
    
echo '<li class="marginTop40 col-md-12 uhu titleSource"> <br/> <p align="center">' .$this->t('{uhutheme:uhutheme:select_other_source_text}'). '</p> </li>';

foreach ($this->data['sources'] as $source) {
    $variable = htmlspecialchars($source['source']);
    $largo = strlen($variable); #capturamos el largo de la cadena
    $subcadena = substr($variable, $largo-4); #capturamos los 4 ultimos caracteres de la cadena

    if ($subcadena != "-uhu") {
        echo '<li class="list-group-item' . htmlspecialchars($source['css_class']) . ' authsourcem col-md-4 uhu">';
        if ($source['source'] === $this->data['preferred']) {
            $autofocus = ' autofocus="autofocus"';
        } else {
            $autofocus = '';
        }
        $name = 'src-' . base64_encode($source['source']);

        echo '<button class="btn btn-default" type="submit" name="' . htmlspecialchars($name) . '"' . $autofocus . ' ' .
            'id="button-' . htmlspecialchars($source['source']) . '" ' .
            'value="' . htmlspecialchars($source['text']) . '" >
    		<img src="'. \SimpleSAML\Module::getModuleURL('uhutheme/img/authsources/'. htmlspecialchars($source['source'].'.png')).'" </img>
    		</br> <br/>' . htmlspecialchars($source['text']). ' </button>';

        echo '</li>';
    }
}
?>
  </div>
	</ul>

	<div class="row">
<?php
$counter = 0;

foreach ($this->data['sources'] as $source) {
    if ($counter != 0 && $counter % 2 == 0) {
        echo "</div>";
        echo '<div class="row">';
    }
    $counter++;
}
?>

	</div>

</form>
<?php

$this->includeAtTemplateBase('includes/footer_uhu.php');

<?php
if (!empty($this->data['htmlinject']['htmlContentPost'])) {
    foreach ($this->data['htmlinject']['htmlContentPost'] as $c) {
        echo $c;
    }
}
?>

    </div><!-- #regbox -->
  </div><!-- row -->
</div><!-- container -->
</section> <!-- content_consent-->


        <div id="footer" class="col-xs-12 marginTop40">
            <div id="link_area">
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

                $textarray = [];
                foreach ($languages as $lang => $current) {
                    $lang = strtolower($lang);
                    if ($current) {
                        $textarray[] = $langnames[$lang] ;
                    } else {
                        $textarray[] = '<a href="' . htmlspecialchars(SimpleSAML_Utilities::addURLparameter(SimpleSAML_Utilities::selfURL(), ['language' => $lang])) . '">' .
                        $langnames[$lang] . '</a>';
                    }
                }
                if (isset($textarray)) {
                    echo join(" | ", $textarray);
                }
                if (\SimpleSAML\Module::isModuleEnabled('selfregister')) {
                    echo ' | <a href="'.\SimpleSAML\Module::getModuleURL('selfregister/help.php').'">'.$this->t('{selfregister:selfregister:faq}').'</a> | <a href="'.\SimpleSAML\Module::getModuleURL('selfregister/privacy.php').'">'.$this->t('{selfregister:selfregister:privacy}').'</a>';
                }
                
                if (\SimpleSAML\Module::isModuleEnabled('consentAdmin')) {
                    echo ' | <a href="'.\SimpleSAML\Module::getModuleURL('consentAdmin/consentAdmin.php').'">'.$this->t('{consentAdmin:consentadmin:link_consentAdmin}').'</a>';
                }
                
                ?>
            </div>

            <div id="address"> Universidad de Huelva, Todos los Derechos Reservados - Dr. Cantero Cuadrado, 6. 21071 Huelva Teléfono: +34 (959) 21800</div>
        </div><!-- #footer -->
</div><!-- #wrap -->
</body>
</html>

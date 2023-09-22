<?php
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist']['casatimeline_gallery'] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
    // plugin signature: <extension key without underscores> '_' <plugin name in lowercase>
    'casatimeline_gallery',
    // Flexform configuration schema file
    'FILE:EXT:casa_timeline/Configuration/FlexForms/flexform_gallery.xml'
);
//$GLOBALS['TCA']['tx_casatimeline_domain_model_event']['ctrl']['security']['ignorePageTypeRestriction']= true;
//$GLOBALS['TCA']['tx_casatimeline_domain_model_tag']['ctrl']['security']['ignorePageTypeRestriction']= true;

<?php
defined('TYPO3') || die('Access denied.');

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'CasaTimeline',
            'Gallery',
            'Gallery'
        );
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addModule(
    main: 'web',
    sub: 'casa_timeline',
    position: 'top',
    moduleConfiguration:[
        'routeTarget' => \Casa\CasaTimeline\Controller\ModuleController::class,
        'access' => 'user, group',
        'name' => 'web_casa_timeline',
        'iconIdentifier' => 'timeline-plugin-gallery',
        'labels' => 'LLL:EXT:casa_timeline/Resources/Private/Language/casa_timeline.xlf'
    ]
);

// (function () {
//     // Add extra fields to User Settings (field is defined for TCA too in Configuration/TCA/Overrides/be_users.php)
//     // IMPORTANT: We need to define a dependency on sysext:setup to ensure that the loading order is correct and
//     // the configuration is properly applied.
//     $GLOBALS['TYPO3_USER_SETTINGS']['columns']['tx_casa_timeline'] = [
//         'label' => 'LLL:EXT:tx_casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casa_timeline',
//         'type' => 'text',
//         'table' => 'be_users',
//     ];
//     \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addFieldsToUserSettings(
//         'tx_casa_timeline',
//         'after:email'
//     );

//     // Settings for new tables, which do not belong to Configuration/TCA

//     // Define a new doktype
//     $customPageDoktype = 116;
//     // Add page type to system
//     $dokTypeRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\DataHandling\PageDoktypeRegistry::class);
//     $dokTypeRegistry->add(
//         $customPageDoktype,
//         [
//             'type' => 'web',
//             'allowedTables' => '*',
//         ]
//     );
// })();





// call_user_func(
//     function()
//     {

//         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
//             'CasaTimeline',
//             'Gallery',
//             'Gallery'
//         );

//         if (TYPO3 === 'BE') {

//             // \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
//             //     'Casa.CasaTimeline',
//             //     'web', // Make module a submodule of 'web'
//             //     'casa_timeline', // Submodule key
//             //     '', // Position
//             //     [
//             //         'Event' => 'list, show, new, create, edit, update, delete',
//             //         'Tag' => 'list, new, create, delete',
//             //         'Ajax' => 'gallery',
//             //     ],
//             //     [
//             //         'access' => 'user,group',
//             //         'icon'   => 'EXT:casa_timeline/Resources/Public/Icons/ext_icon.jpg',
//             //         'labels' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_timeline.xlf',
//             //     ]
//             // );

//         }

//         \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('casa_timeline', 'Configuration/TypoScript', 'Timeline');

//         // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_casatimeline_domain_model_event', 'EXT:casa_timeline/Resources/Private/Language/locallang_csh_tx_casatimeline_domain_model_event.xlf');
//         // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_casatimeline_domain_model_event');

//         // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_casatimeline_domain_model_tag', 'EXT:casa_timeline/Resources/Private/Language/locallang_csh_tx_casatimeline_domain_model_tag.xlf');
//         // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_casatimeline_domain_model_tag');

//     }
// );

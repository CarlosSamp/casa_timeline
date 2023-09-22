<?php
//defined('TYPO3_MODE') || die('Access denied.');

(function () {

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'CasaTimeline',
        'Gallery',
        [
            \Casa\CasaTimeline\Controller\EventController::class => 'list, show, new, create, edit, update, delete, sendmail',
            \Casa\CasaTimeline\Controller\TagController::class => 'list, new, create, delete',
        ],
        [
            \Casa\CasaTimeline\Controller\EventController::class => 'list, show, new, create, edit, update, delete, sendmail',
            \Casa\CasaTimeline\Controller\TagController::class => 'list, new, create, delete',
        ]
    );

    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'CasaTimeline',
        'Meinajax',
        [
            \Casa\CasaTimeline\Controller\EventController::class => 'list',
            \Casa\CasaTimeline\Controller\AjaxController::class => 'gallery, timeline',
        ],
        [
            \Casa\CasaTimeline\Controller\EventController::class => 'list',
            \Casa\CasaTimeline\Controller\AjaxController::class => 'gallery, timeline',
        ]
    );

    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

    $iconRegistry->registerIcon(
      'timeline-plugin-gallery',
      \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
      ['source' => 'EXT:casa_timeline/Resources/Public/Icons/ext_icon.svg']
    );
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        'mod {
            wizards.newContentElement.wizardItems.plugins {
                elements {
                    gallery {
                        iconIdentifier = timeline-plugin-gallery
                        title = LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casa_timeline_gallery.name
                        description = LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casa_timeline_gallery.description
                        tt_content_defValues {
                            CType = list
                            list_type = casatimeline_gallery
                        }
                    }
                }
                show = *
            }
       }'
    );


})();

// call_user_func(
//     function()
//     {

//       //unset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['TYPO3\CMS\Frontend\Page\PageGenerator']['generateMetaTags']['canonical']);

//         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
//             'CasaTimeline',
//             'Gallery',
//             [
//                 'Event' => 'list, show, new, create, edit, update, delete, sendmail', 'slug',
//                 'Tag' => 'list, new, create, delete'
//             ],
//             // non-cacheable actions
//             [
//                 'Event' => 'create, update, delete, show, slug',
//                 'Tag' => 'create, delete'
//             ]
//         );
//         \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
//             'CasaTimeline',
//             'Meinajax',
//             [
//                 'Event' => 'list',
//                 'Ajax' => 'gallery, timeline'
//             ],
//             // non-cacheable actions
//             [
//                 'Event' => 'list',
//                 'Ajax' => 'gallery, timeline'
//             ]
//         );

//     // wizards
//     $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

//     $iconRegistry->registerIcon(
//       'timeline-plugin-gallery',
//       \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
//       ['source' => 'EXT:casa_timeline/Resources/Public/Icons/ext_icon.svg']
//     );
//     \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
//         'mod {
//             wizards.newContentElement.wizardItems.plugins {
//                 elements {
//                     gallery {
//                         iconIdentifier = timeline-plugin-gallery
//                         title = LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casa_timeline_gallery.name
//                         description = LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casa_timeline_gallery.description
//                         tt_content_defValues {
//                             CType = list
//                             list_type = casatimeline_gallery
//                         }
//                     }
//                 }
//                 show = *
//             }
//        }'
//     );


//     }
// );

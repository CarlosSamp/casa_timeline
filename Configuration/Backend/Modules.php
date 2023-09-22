<?php
use Casa\CasaTimeline\Controller\EventController;
use Casa\CasaTimeline\Controller\TagController;
use Casa\CasaTimeline\Controller\AjaxController;
//use T3docs\Examples\Controller\AdminModuleController;

/**
 * Definitions for modules provided by EXT:examples
 */
// return [
//     'web_module' => [
//         'parent' => 'web',
//         'position' => ['before' => '*'],
//         'access' => 'admin',
//         'workspaces' => '*',
//         'path' => '/module/web/casa_timeline',
//         'iconIdentifier' => 'timeline-plugin-gallery',
//         'navigationComponent' => 'TYPO3/CMS/Backend/PageTree/PageTreeElement',
//         'labels' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_mod.xlf',
//         'routes' => [
//             '_default' => [
//                 'target' => EventController::class . '::list',
//             ],
//             'list' => [
//                 'path' => '/edit-me',
//                 'target' => EventController::class . '::list',
//             ],
//             'gallery' => [
//                 'path' => '/edit-me',
//                 'target' => AjaxController::class . '::gallery',
//             ],
//         ],
        
//     ],

//     'web_CasaTimeline' => [
//         'parent' => 'web',
//         'position' => ['after' => 'web_info'],
//         'access' => 'admin',
//         'workspaces' => '*',
//         'iconIdentifier' => 'timeline-plugin-gallery',
//         'path' => '/module/web/CasaTimeline',
//         'labels' => 'LLL:EXT:beuser/Resources/Private/Language/locallang_mod.xlf',
//         'extensionName' => 'CasaTimeline',
//         'controllerActions' => [
//             EventController::class => [
//                 'list',
//                 'show', 'new', 'create'
//             ],
//             AjaxController::class => [
//                 'gallery'
//             ],
//         ],
//     ],
// ];

            //         'Event' => 'list, show, new, create, edit, update, delete',
            //         'Tag' => 'list, new, create, delete',
            //         'Ajax' => 'gallery',
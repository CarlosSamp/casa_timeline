<?php
return [
    'ctrl' => [
        'title' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casatimeline_domain_model_event',
        'label' => 'eventstartdate',
        'label_userFunc' => \Casa\CasaTimeline\Userfuncs\Tca::class . '->eventTitle',
        'default_sortby' =>  ' ORDER BY eventstartdate DESC',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'versioningWS' => true,
        'languageField' => 'sys_language_uid',
        'transOrigPointerField' => 'l10n_parent',
        'transOrigDiffSourceField' => 'l10n_diffsource',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
            'starttime' => 'starttime',
            'endtime' => 'endtime',
        ],
        'searchFields' => 'description, slug',
        'iconfile' => 'EXT:casa_timeline/Resources/Public/Icons/tx_casatimeline_domain_model_event.gif'
    ],
    'interface' => [
        'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, eventstartdate, titel, slug, description, share, image, tags, persons, images',
    ],
    'types' => [
        '1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden,
        --palette--;Details;date,
         titel, slug, description, image, tags, persons, images, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
    ],
    'columns' => [
        'sys_language_uid' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'special' => 'languages',
                'items' => [
                    [
                        'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
                        -1,
                        'flags-multiple'
                    ]
                ],
                'default' => 0,
            ],
        ],
        'l10n_parent' => [
            'displayCond' => 'FIELD:sys_language_uid:>:0',
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectSingle',
                'default' => 0,
                'items' => [
                    ['', 0],
                ],
                'foreign_table' => 'tx_casatimeline_domain_model_event',
                'foreign_table_where' => 'AND {#tx_casatimeline_domain_model_event}.{#pid}=###CURRENT_PID### AND {#tx_casatimeline_domain_model_event}.{#sys_language_uid} IN (-1,0)',
            ],
        ],
        'l10n_diffsource' => [
            'config' => [
                'type' => 'passthrough',
            ],
        ],
        't3ver_label' => [
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'max' => 255,
            ],
        ],
        'hidden' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        0 => '',
                        1 => '',
                        'invertStateDisplay' => true
                    ]
                ],
            ],
        ],
        'starttime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'date,int',
                'default' => 0,
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],
        'endtime' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
            'config' => [
                'type' => 'input',
                'renderType' => 'inputDateTime',
                'eval' => 'datetime,int',
                'default' => 0,
                'range' => [
                    'upper' => mktime(0, 0, 0, 1, 1, 2038)
                ],
                'behaviour' => [
                    'allowLanguageSynchronization' => true
                ]
            ],
        ],

        'eventstartdate' => [
            'exclude' => true,
            'label' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casatimeline_domain_model_event.date',
            'config' => [
               'type' => 'input',
               'renderType' => 'inputDateTime',
               'eval' => 'date,int',
               'default' => 0,
               'behaviour' => [
                   'allowLanguageSynchronization' => true
               ]
            ],
        ],
        'titel' => [
            'exclude' => true,
            'label' => 'Titel',
            'config' => [
                'type' => 'input',
                'size' => 30,
                'eval' => 'trim'
            ],
        ],
        'description' => [
            'exclude' => true,
            'label' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casatimeline_domain_model_event.description',
            'config' => [
                'type' => 'text',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default',
                'fieldControl' => [
                  'fullScreenRichtext' => [
                      'disabled' => false,
                  ],
                ],
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ],
        ],
        'share' => [
            'exclude' => true,
            'label' => 'Öffentlich',
            'config' => [
                'type' => 'check',
                'renderType' => 'checkboxToggle',
                'items' => [
                    [
                        '0' => 'LLL:EXT:lang/locallang_core.xlf:labels.enabled',
                        'labelChecked' => 'Enabled',
                        'labelUnchecked' => 'Disabled',
                    ],
                ],
                'default' => 0,
            ]
        ],
        // 'image' => [
        //     'exclude' => true,
        //     'label' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casatimeline_domain_model_event.image',
        //     'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
        //         'image',
        //         [
        //             'appearance' => [
        //                 'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
        //                 'collapseAll' => 1
        //             ],
        //             'foreign_types' => [
        //                 '0' => [
        //                     'showitem' => '
        //                     --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
        //                     --palette--;;filePalette'
        //                 ],
        //                 \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
        //                     'showitem' => '
        //                     --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
        //                     --palette--;;filePalette'
        //                 ],
        //                 \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
        //                     'showitem' => '
        //                     --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
        //                     --palette--;;filePalette'
        //                 ],
        //                 \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
        //                     'showitem' => '
        //                     --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
        //                     --palette--;;filePalette'
        //                 ],
        //                 \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
        //                     'showitem' => '
        //                     --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
        //                     --palette--;;filePalette'
        //                 ],
        //                 \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
        //                     'showitem' => '
        //                     --palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
        //                     --palette--;;filePalette'
        //                 ]
        //             ],
        //             'maxitems' => 1
        //         ],
        //         $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
        //     ),
        // ],

        'image' => [
            'label' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references',
            'config' => [
              'type' => 'file',
              'allowed' => ['common-image-types','common-media-types'],
            ]
            // \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig('image', [
            //     'appearance' => [
            //         'createNewRelationLinkTitle' => 'LLL:EXT:frontend/Resources/Private/Language/Database.xlf:tt_content.asset_references.addFileReference',
            //         'collapseAll' => 1
            //     ],
            //     // custom configuration for displaying fields in the overlay/reference table
            //     // behaves the same as the image field.
            //     'overrideChildTca' => [
            //         'types' => [
            //             '0' => [
            //                 'showitem' => '
            //                     --palette--;;imageoverlayPalette,
            //                     --palette--;;filePalette'
            //             ],
            //             \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
            //                 'showitem' => '
            //                     --palette--;;imageoverlayPalette,
            //                     --palette--;;filePalette'
            //             ],
            //             \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
            //                 'showitem' => '
            //                     --palette--;;imageoverlayPalette,
            //                     --palette--;;filePalette'
            //             ],
            //             \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
            //                 'showitem' => '
            //                     --palette--;;audioOverlayPalette,
            //                     --palette--;;filePalette'
            //             ],
            //             \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
            //                 'showitem' => '
            //                     --palette--;;videoOverlayPalette,
            //                     --palette--;;filePalette'
            //             ],
            //             \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
            //                 'showitem' => '
            //                     --palette--;;imageoverlayPalette,
            //                     --palette--;;filePalette'
            //             ]
            //         ],
            //     ],
            // ]
            // , $GLOBALS['TYPO3_CONF_VARS']['SYS']['mediafile_ext'])
        ],
        'tags' => [
            'exclude' => true,
            'label' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casatimeline_domain_model_event.tags',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'foreign_table' => 'tx_casatimeline_domain_model_tag',
                'MM' => 'tx_casatimeline_event_tag_mm',
                'items' => [
                    ['', 0],
                ],
                'size' => 5,
                'minitems' => 0,
                'maxitems' => 10,
            ],

        ],
        'images' => [
            'exclude' => true,
            'label' => 'LLL:EXT:casa_timeline/Resources/Private/Language/locallang_db.xlf:tx_casatimeline_domain_model_event.images',
            'config' => [
              'type' => 'file',
              'allowed' => ['common-image-types','common-media-types'],
            ]

        ],
        'persons' => [
            'exclude' => true,
            'label' => 'Personen',
            'config' => [
              'type' => 'select',
              'renderType' => 'selectMultipleSideBySide',
              'foreign_table' => 'fe_users',
              'MM_opposite_field' => 'events',
              'MM' => 'tx_casatimeline_event_fe_users_mm',
              'items' => [
                  ['', 0],
              ],
              'size' => 5,
              'minitems' => 0,
              'maxitems' => 10,
            ],

        ],
        'slug' => [
            'exclude' => true,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_tca.xlf:pages.slug',
            //'displayCond' => 'USER:' . \TYPO3\CMS\Core\Compatibility\PseudoSiteTcaDisplayCondition::class . '->isInPseudoSite:pages:false',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['titel'],
                    'fieldSeparator' => '/',
                    'prefixParentPageSlug' => true,
                    'replacements' => [
                          '/' => '',
                      ],
                ],
                // 'appearance' => [
                //    'prefix' => 'TYPO3\\CMS\\Styleguide\\UserFunctions\\FormEngine\\SlugPrefix->getPrefix'
                // ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
    ],
    'palettes' => [
      'date' => [
        'showitem' => '
            eventstartdate, share',
      ],

    ],
];

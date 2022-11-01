<?php
# PackageStates.php

# This file is maintained by TYPO3's package management. Although you can edit it
# manually, you should rather use the extension manager for maintaining packages.
# This file will be regenerated automatically if it doesn't exist. Deleting this file
# should, however, never become necessary if you use the package commands.

return [
    'packages' => [
        'core' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-core',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/core/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'extbase' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-extbase',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/extbase/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'fluid' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-fluid',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/fluid/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'scheduler' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-scheduler',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/scheduler/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'indexed_search' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-indexed-search',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/indexed_search/',
            'classesPath' => 'Classes/',
            'suggestions' => [
                'scheduler',
            ],
        ],
        'info' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-info',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/info/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'info_pagetsconfig' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-info-pagetsconfig',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/info_pagetsconfig/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'extensionmanager' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-extensionmanager',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/extensionmanager/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'lang' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-lang',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/lang/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'setup' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-setup',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/setup/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'rtehtmlarea' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-rtehtmlarea',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/rtehtmlarea/',
            'classesPath' => 'Classes/',
            'suggestions' => [
                'setup',
            ],
        ],
        'rsaauth' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-rsaauth',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/rsaauth/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'saltedpasswords' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-saltedpasswords',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/saltedpasswords/',
            'classesPath' => 'Classes/',
            'suggestions' => [
                'rsaauth',
            ],
        ],
        'func' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-func',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/func/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'wizard_crpages' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-wizard-crpages',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/wizard_crpages/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'wizard_sortpages' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-wizard-sortpages',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/wizard_sortpages/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'aboutmodules' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-aboutmodules',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/aboutmodules/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'backend' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-backend',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/backend/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'belog' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-belog',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/belog/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'beuser' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-beuser',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/beuser/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'context_help' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-context-help',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/context_help/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'css_styled_content' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-css-styled-content',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/css_styled_content/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'felogin' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-felogin',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/felogin/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'filelist' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-filelist',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/filelist/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'form' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-form',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/form/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'frontend' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-frontend',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/frontend/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'impexp' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-impexp',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/impexp/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'install' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-install',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/install/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'lowlevel' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-lowlevel',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/lowlevel/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'recordlist' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-recordlist',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/recordlist/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'reports' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-reports',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/reports/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'sv' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-sv',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/sv/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'sys_note' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-sys-note',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/sys_note/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        't3editor' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-t3editor',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/t3editor/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        't3skin' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-t3skin',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/t3skin/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'tstemplate' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-tstemplate',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/tstemplate/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'viewpage' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-viewpage',
            'state' => 'active',
            'packagePath' => 'typo3/sysext/viewpage/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'realurl' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/realurl/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'dmitryd/typo3-realurl',
        ],
        'static_info_tables' => [
            'composerName' => 'sjbr/static-info-tables',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/static_info_tables/',
            'suggestions' => [],
        ],
        'aimeos' => [
            'composerName' => 'aimeos/aimeos-typo3',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/aimeos/',
            'suggestions' => [
                'realurl',
            ],
        ],
        'aimeos_pay' => [
            'composerName' => 'aimeos_pay',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/aimeos_pay/',
            'suggestions' => [],
        ],
        'frey_aimeos' => [
            'composerName' => 'frey_aimeos',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/frey_aimeos/',
            'suggestions' => [],
        ],
        'gridelements' => [
            'composerName' => 'GridElementsTeam/Gridelements',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/gridelements/',
            'suggestions' => [],
        ],
        'bootstrap_grids' => [
            'composerName' => 'laxap/bootstrap-grids',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/bootstrap_grids/',
            'suggestions' => [],
        ],
        'jftcaforms' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/jftcaforms/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'jftcaforms',
        ],
        'imagecycle' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/imagecycle/',
            'classesPath' => 'Classes/',
            'suggestions' => [
                'jftcaforms',
            ],
            'composerName' => 'typo3-extension/imagecycle',
        ],
        'automaketemplate' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/automaketemplate/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'automaketemplate',
        ],
        'cl_jquery_fancybox' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/cl_jquery_fancybox/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'cl_jquery_fancybox',
        ],
        'go_maps_ext' => [
            'composerName' => 'clickstorm/go_maps_ext',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/go_maps_ext/',
            'suggestions' => [],
        ],
        'news' => [
            'composerName' => 'georgringer/news',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/news/',
            'suggestions' => [],
        ],
        'ns_ext_compatibility' => [
            'composerName' => 'nitsan/ns_ext_compatibility',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/ns_ext_compatibility/',
            'suggestions' => [],
        ],
        'nwt_imagecrop' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/nwt_imagecrop/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'nwt_imagecrop',
        ],
        'powermail' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/powermail/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'in2code/powermail',
        ],
        'seo_basics' => [
            'composerName' => 'b13/seo_basics',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/seo_basics/',
            'suggestions' => [],
        ],
        'sg_contentlink' => [
            'composerName' => 'sgalinski/sg-contentlink',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/sg_contentlink/',
            'suggestions' => [],
        ],
        't3jquery' => [
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/t3jquery/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 't3jquery',
        ],
        'ws_flexslider' => [
            'composerName' => 'ws_flexslider',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/ws_flexslider/',
            'suggestions' => [],
        ],
        'ws_scss' => [
            'composerName' => 'svewap/ws-scss',
            'state' => 'active',
            'packagePath' => 'typo3conf/ext/ws_scss/',
            'suggestions' => [],
        ],
        'about' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-about',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/about/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'adodb' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-adodb',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/adodb/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'cshmanual' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-cshmanual',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/cshmanual/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'dbal' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-dbal',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/dbal/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'documentation' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-documentation',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/documentation/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'feedit' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-feedit',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/feedit/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'filemetadata' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-filemetadata',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/filemetadata/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'fluid_styled_content' => [
            'composerName' => 'typo3/cms-fluid-styled-content',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/fluid_styled_content/',
            'suggestions' => [],
        ],
        'indexed_search_mysql' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-indexed-search-mysql',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/indexed_search_mysql/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'linkvalidator' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-linkvalidator',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/linkvalidator/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'maag_randomimage' => [
            'state' => 'inactive',
            'packagePath' => 'typo3conf/ext/maag_randomimage/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
            'composerName' => 'maag_randomimage',
        ],
        'mw_shell' => [
            'composerName' => 'mw_shell',
            'state' => 'inactive',
            'packagePath' => 'typo3conf/ext/mw_shell/',
            'suggestions' => [],
        ],
        'opendocs' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-opendocs',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/opendocs/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'recycler' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-recycler',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/recycler/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'sys_action' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-sys-action',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/sys_action/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'taskcenter' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-taskcenter',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/taskcenter/',
            'classesPath' => 'Classes/',
            'suggestions' => [
                'sys_action',
            ],
        ],
        'version' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-version',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/version/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
        'workspaces' => [
            'manifestPath' => '',
            'composerName' => 'typo3/cms-workspaces',
            'state' => 'inactive',
            'packagePath' => 'typo3/sysext/workspaces/',
            'classesPath' => 'Classes/',
            'suggestions' => [],
        ],
    ],
    'version' => 4,
];
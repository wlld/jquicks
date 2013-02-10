<?
array (
  'components' =>array (
    0 =>array (
      'c' => 'TPage',
      'n' => 'pages',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'title' =>array (
          0 => 'string',
          1 => 'Менеджер проекта',
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 1,
        ),
        'keywords' =>array (
          0 => 'string',
          1 => '',
        ),
        'description' =>array (
          0 => 'string',
          1 => '',
        ),
        'P3P' =>array (
          0 => 'string',
          1 => 'CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE',
        ),
      ),
      'u' =>array (
        0 => 19,
        1 => 24,
        2 => 26,
      ),
      's' =>array (
        0 =>array (
          0 => 27,
          1 => 25,
          2 => 21,
        ),
      ),
    ),
    1 =>array (
      'c' => 'TComponentsTree',
      'n' => 'pagetree',
      'l' =>array (
        20 => 1,
      ),
      'm' =>array (
        'treemodel' => 50,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'service' =>array (
          0 => 'component(TPageEditService)',
          1 => 'page_edit_service',
        ),
      ),
    ),
    2 =>array (
      'c' => 'TComponentEditor',
      'n' => 'component_editor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 2,
        ),
        'groups' =>array (
          0 => 'object',
          1 =>array (
            'prpeditor' => '012',
            'csseditor' => '1',
            'tpleditor' => '1',
            'linkseditor' => '2',
          ),
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 4,
          1 => 5,
          2 => 6,
          3 => 67,
        ),
        1 =>array (
          0 => 7,
        ),
      ),
    ),
    3 =>array (
      'c' => 'TContainer',
      'n' => 'page_editor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 2,
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 8,
          1 => 9,
          2 => 10,
        ),
        1 =>array (
          0 => 11,
        ),
      ),
    ),
    4 =>array (
      'c' => 'TPrpEditor',
      'n' => 'prpeditor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
      'm' =>array (
        'prpmodel' => 51,
      ),
    ),
    5 =>array (
      'c' => 'TCSSEditor',
      'n' => 'csseditor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
      'm' =>array (
        'cssmodel' => 52,
      ),
    ),
    6 =>array (
      'c' => 'TTplEditor',
      'n' => 'tpleditor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
      'm' =>array (
        'tplmodel' => 53,
      ),
    ),
    7 =>array (
      'c' => 'TPageSelector',
      'n' => 'prp_css_selector',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'pages' =>array (
          0 => 'object',
          1 =>array (
            0 => 'prpeditor',
            1 => 'csseditor',
            2 => 'tpleditor',
            3 => 'linkseditor',
          ),
        ),
        'visibility' =>array (
          0 => 'object',
          1 =>array (
            0 => 0,
            1 => 0,
            2 => 0,
            3 => 0,
          ),
        ),
        'active' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'changable' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    8 =>array (
      'c' => 'TContainer',
      'n' => 'html_editor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 1,
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 16,
          1 => 17,
        ),
      ),
    ),
    9 =>array (
      'c' => 'TJsEditor',
      'n' => 'js_editor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
      'm' =>array (
        'jsmodel' => 54,
      ),
    ),
    10 =>array (
      'c' => 'TPHPEditor',
      'n' => 'php_editor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
      'm' =>array (
        'phpmodel' => 55,
      ),
    ),
    11 =>array (
      'c' => 'TPageSelector',
      'n' => 'html_js_php_selector',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'pages' =>array (
          0 => 'object',
          1 =>array (
            0 => 'html_editor',
            1 => 'js_editor',
            2 => 'php_editor',
          ),
        ),
        'visibility' =>array (
          0 => 'object',
          1 =>array (
            0 => 1,
            1 => 1,
            2 => 1,
          ),
        ),
        'active' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'changable' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    12 =>array (
      'c' => 'TVidget',
      'n' => 'msglist',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    13 =>array (
      'c' => 'TPageSelector',
      'n' => 'palette_page_selector',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'pages' =>array (
          0 => 'object',
          1 =>array (
            0 => 'palette_page_1',
            1 => 'palette_page_2',
            2 => 'palette_page_3',
          ),
        ),
        'titles' =>array (
          0 => 'object',
          1 =>array (
            0 => 'Стандартные',
            1 => 'Службы',
            2 => 'jquicks',
          ),
        ),
        'active' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'visibility' =>array (
          0 => 'object',
          1 =>array (
            0 => 1,
            1 => 1,
            2 => 1,
          ),
        ),
        'changable' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    14 =>array (
      'c' => 'TPalettePage',
      'n' => 'palette_page_1',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'components' =>array (
          0 => 'object',
          1 =>array (
            0 => 'TVidget',
            1 => 'TContainer',
            2 => 'TModelPageControl',
            3 => 'TModel',
            4 => 'TActionServer',
            5 => 'TDataBase',
            6 => 'TLoginDialog',
            7 => 'TForm',
            8 => 'TRegistrationForm',
            9 => 'TLibrary',
          ),
        ),
      ),
    ),
    15 =>array (
      'c' => 'TPalettePage',
      'n' => 'palette_page_2',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'components' =>array (
          0 => 'object',
          1 =>array (
            0 => 'TTableCtrlService',
            1 => 'TPageEditService',
            2 => 'TAccountService',
            3 => 'TForumService',
            4 => 'TDiscussService',
            5 => 'TServiceController',
          ),
        ),
      ),
    ),
    16 =>array (
      'c' => 'THTMLPreview',
      'n' => 'frame',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    17 =>array (
      'c' => 'TContainer',
      'n' => 'palette',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 2,
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 14,
          1 => 15,
          2 => 46,
        ),
        1 =>array (
          0 => 13,
        ),
      ),
    ),
    18 =>array (
      'c' => 'TPageEditService',
      'n' => 'page_edit_service',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
      ),
    ),
    19 =>array (
      'c' => 'TActionServer',
      'n' => 'TActionServer',
      'l' =>array (
        0 => 1,
        20 => 1,
        57 => 1,
        73 => 1,
      ),
      'p' =>array (
      ),
    ),
    20 =>array (
      'c' => 'TPage',
      'n' => 'pageeditor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'title' =>array (
          0 => 'string',
          1 => 'Конструктор страницы',
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 3,
        ),
        'keywords' =>array (
          0 => 'string',
          1 => '',
        ),
        'description' =>array (
          0 => 'string',
          1 => '',
        ),
        'P3P' =>array (
          0 => 'string',
          1 => 'CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE',
        ),
      ),
      'u' =>array (
        0 => 86,
        1 => 18,
        2 => 19,
      ),
      's' =>array (
        0 =>array (
          0 => 1,
          1 => 2,
        ),
        1 =>array (
          0 => 28,
          1 => 3,
          2 => 12,
        ),
        2 =>array (
          0 => 72,
          1 => 60,
          2 => 65,
        ),
      ),
    ),
    21 =>array (
      'c' => 'TVidget',
      'n' => 'pagelist',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    24 =>array (
      'c' => 'TModel',
      'n' => 'pmodel',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'pageeditservice',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'page',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'name',
            1 => 'params',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
            'project' => 'site',
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'data',
        ),
      ),
    ),
    25 =>array (
      'c' => 'TVidget',
      'n' => 'newpage',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    26 =>array (
      'c' => 'TPageEditService',
      'n' => 'pageeditservice',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
      ),
    ),
    27 =>array (
      'c' => 'TVidget',
      'n' => 'prgname',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    28 =>array (
      'c' => 'TComponentsList',
      'n' => 'allcmp',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'edit_service' =>array (
          0 => 'component(TPageEditService)',
          1 => 'page_edit_service',
        ),
      ),
      'm' =>array (
        'model' => 56,
      ),
    ),
    29 =>array (
      'c' => 'TPage',
      'n' => 'changelog',
      'l' =>array (
        29 => 1,
      ),
      'p' =>array (
        'title' =>array (
          0 => 'string',
          1 => '',
        ),
        'keywords' =>array (
          0 => 'string',
          1 => '',
        ),
        'description' =>array (
          0 => 'string',
          1 => '',
        ),
        'P3P' =>array (
          0 => 'string',
          1 => 'CAO DSP COR CURa ADMa DEVa OUR IND PHY ONL UNI COM NAV INT DEM PRE',
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 1,
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 30,
          1 => 64,
        ),
      ),
      'u' =>array (
      ),
    ),
    30 =>array (
      'c' => 'TVidget',
      'n' => 'jq1_0a3',
      'l' =>array (
        29 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    31 =>array (
      'c' => 'TPage',
      'n' => 'servicehelp',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
      ),
      's' =>array (
        0 =>array (
          0 => 32,
          1 => 33,
          2 => 34,
          3 => 41,
          4 => 42,
        ),
      ),
      'u' =>array (
        0 => 36,
        1 => 37,
        2 => 38,
        3 => 39,
        4 => 40,
        5 => 35,
      ),
    ),
    32 =>array (
      'c' => 'TVidget',
      'n' => 'title',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    33 =>array (
      'c' => 'TVidget',
      'n' => 'briefmodels',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    34 =>array (
      'c' => 'TVidget',
      'n' => 'briefcommands',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    35 =>array (
      'c' => 'TServiceController',
      'n' => 'servicehelper_1',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
      ),
    ),
    36 =>array (
      'c' => 'TModel',
      'n' => 'mmodels',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'servicehelper_1',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'models',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'none',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    37 =>array (
      'c' => 'TModel',
      'n' => 'mfields',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'servicehelper_1',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'fields',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'none',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    38 =>array (
      'c' => 'TModel',
      'n' => 'mfetchp',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'servicehelper_1',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'fetchparams',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'none',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    39 =>array (
      'c' => 'TModel',
      'n' => 'mcmdp',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'servicehelper_1',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'cmdparams',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'none',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    40 =>array (
      'c' => 'TModel',
      'n' => 'mcmd',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'servicehelper_1',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'commands',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'none',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    41 =>array (
      'c' => 'TVidget',
      'n' => 'fullmodels',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    42 =>array (
      'c' => 'TVidget',
      'n' => 'fullcommands',
      'l' =>array (
        31 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    46 =>array (
      'c' => 'TPalettePage',
      'n' => 'palette_page_3',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'components' =>array (
          0 => 'object',
          1 =>array (
            0 => 'TPalettePage',
            1 => 'TCoreRightsEditor',
            2 => 'TTextSpeedEditor',
            3 => 'TLinkSpeedEditor',
            4 => 'TLinksCheckingDialog',
            5 => 'TLinksEditor',
          ),
        ),
      ),
    ),
    50 =>array (
      'c' => 'TModel',
      'n' => 'pagetree.treemodel',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'page',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'tree',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'data',
        ),
      ),
    ),
    51 =>array (
      'c' => 'TModel',
      'n' => 'prpeditor.prpmodel',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'properties',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
      ),
    ),
    52 =>array (
      'c' => 'TModel',
      'n' => 'csseditor.cssmodel',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'component',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'css',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
      ),
    ),
    53 =>array (
      'c' => 'TModel',
      'n' => 'tpleditor.tplmodel',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'component',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'tpl',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
      ),
    ),
    54 =>array (
      'c' => 'TModel',
      'n' => 'js_editor.jsmodel',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'page',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'js',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
      ),
    ),
    55 =>array (
      'c' => 'TModel',
      'n' => 'php_editor.phpmodel',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'page',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'php',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
      ),
    ),
    56 =>array (
      'c' => 'TModel',
      'n' => 'allcmp.model',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'component',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'name',
            1 => 'type',
            2 => 'group',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
            'exclude' => 'TContainer',
            'order' => 'SMART',
            'set' => 'NOT_IN_PAGE',
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
      ),
    ),
    57 =>array (
      'c' => 'TPage',
      'n' => 'srvcompiler',
      'l' =>array (
        57 => 1,
      ),
      'p' =>array (
        'title' =>array (
          0 => 'string',
          1 => '',
        ),
        'keywords' =>array (
          0 => 'string',
          1 => '',
        ),
        'description' =>array (
          0 => 'string',
          1 => '',
        ),
        'P3P' =>array (
          0 => 'string',
          1 => '',
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 1,
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 58,
        ),
      ),
      'u' =>array (
        0 => 19,
        1 => 59,
      ),
    ),
    58 =>array (
      'c' => 'TVidget',
      'n' => 'vidget_1',
      'l' =>array (
        57 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    59 =>array (
      'c' => 'TServiceController',
      'n' => 'TServiceController',
      'l' =>array (
        57 => 1,
      ),
      'p' =>array (
      ),
    ),
    60 =>array (
      'c' => 'TTextSpeedEditor',
      'n' => 'textspeededitor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
      ),
    ),
    64 =>array (
      'c' => 'TVidget',
      'n' => 'jq1_0a4',
      'l' =>array (
        29 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    65 =>array (
      'c' => 'TLinksCheckingDialog',
      'n' => 'linkscheckingdialog',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
      ),
    ),
    66 =>array (
      'c' => 'TModel',
      'n' => 'linkseditor.model',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'links',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    67 =>array (
      'c' => 'TLinksEditor',
      'n' => 'linkseditor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'speededitor' =>array (
          0 => 'component(TLinkSpeedEditor)',
          1 => 'linkspeededitor',
        ),
        'checker' =>array (
          0 => 'component(TLinksCheckingDialog)',
          1 => 'linkscheckingdialog',
        ),
      ),
      'm' =>array (
        'model' => 66,
      ),
    ),
    68 =>array (
      'c' => 'TCacheModel',
      'n' => 'linkspeededitor.mchild',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'TServiceController',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'models',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'name',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    69 =>array (
      'c' => 'TModel',
      'n' => 'linkspeededitor.mlfield',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'TServiceController',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'fields',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'name',
            1 => 'link',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    70 =>array (
      'c' => 'TModel',
      'n' => 'linkspeededitor.mservice',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'page_edit_service',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'component',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'name',
            1 => 'type',
            2 => 'id',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    71 =>array (
      'c' => 'TCacheModel',
      'n' => 'linkspeededitor.mparent',
      'l' => false,
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'TServiceController',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'models',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'name',
            1 => 'desc',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    72 =>array (
      'c' => 'TLinkSpeedEditor',
      'n' => 'linkspeededitor',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
      ),
      'm' =>array (
        'mchild' => 68,
        'mlfield' => 69,
        'mservice' => 70,
        'mparent' => 71,
      ),
    ),
    73 =>array (
      'c' => 'TPage',
      'n' => 'index',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'title' =>array (
          0 => 'string',
          1 => 'Main page of jquicks',
        ),
        'keywords' =>array (
          0 => 'string',
          1 => '',
        ),
        'description' =>array (
          0 => 'string',
          1 => '',
        ),
        'P3P' =>array (
          0 => 'string',
          1 => '',
        ),
        'sections' =>array (
          0 => 'integer',
          1 => 4,
        ),
      ),
      's' =>array (
        0 =>array (
          0 => 74,
        ),
        1 =>array (
          0 => 75,
        ),
        2 =>array (
          0 => 85,
          1 => 76,
          2 => 77,
        ),
        3 =>array (
          0 => 82,
          1 => 83,
          2 => 84,
        ),
      ),
      'u' =>array (
        0 => 19,
        1 => 78,
        2 => 79,
        3 => 80,
        4 => 81,
      ),
    ),
    74 =>array (
      'c' => 'TVidget',
      'n' => 'logo',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    75 =>array (
      'c' => 'TVidget',
      'n' => 'menu',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    76 =>array (
      'c' => 'TVidget',
      'n' => 'shelp',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    77 =>array (
      'c' => 'TVidget',
      'n' => 'concept',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    78 =>array (
      'c' => 'TDataBase',
      'n' => 'TDataBase',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'persistent' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    79 =>array (
      'c' => 'TAccountService',
      'n' => 'TAccountService',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'regmode' =>array (
          0 => 'list["BASIC","E-MAIL","ADMIN"]',
          1 => 'BASIC',
        ),
        'check_ip' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'ses_l_time' =>array (
          0 => 'integer',
          1 => 30,
        ),
        'security' =>array (
          0 => 'list["on","off","training"]',
          1 => 'off',
        ),
      ),
    ),
    80 =>array (
      'c' => 'TDiscussService',
      'n' => 'srv_news',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'auth_required' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    81 =>array (
      'c' => 'TModel',
      'n' => 'm_news',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'srv_news',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'messages',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'date',
            1 => 'text',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'params' =>array (
          0 => 'object',
          1 =>array (
          ),
        ),
        'import' =>array (
          0 => 'list["none","class","data"]',
          1 => 'class',
        ),
        'calcfields' =>array (
          0 => 'text',
          1 => '',
        ),
      ),
    ),
    82 =>array (
      'c' => 'TVidget',
      'n' => 'news',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => 'm_news',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    83 =>array (
      'c' => 'TModelPageControl',
      'n' => 'modelpagecontrol_1',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'model' =>array (
          0 => 'component(TModel)',
          1 => 'm_news',
        ),
        'enabled' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    84 =>array (
      'c' => 'TForm',
      'n' => 'frm_new_news',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'model' =>array (
          0 => 'component(TModel)',
          1 => 'm_news',
        ),
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    85 =>array (
      'c' => 'TVidget',
      'n' => 'projects',
      'l' =>array (
        73 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'updatible' =>array (
          0 => 'boolean',
          1 => 0,
        ),
        'view_model' =>array (
          0 => 'component(TModel)',
          1 => '',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    86 =>array (
      'c' => 'TLibrary',
      'n' => 'lib_ace',
      'l' =>array (
        20 => 1,
      ),
      'p' =>array (
        'library' =>array (
          0 => 'string',
          1 => 'ace',
        ),
        'autoload' =>array (
          0 => 'string',
          1 => 'ace.js',
        ),
      ),
    ),
  ),
  'names' =>array (
    'pages' => 0,
    'pagetree' => 1,
    'component_editor' => 2,
    'page_editor' => 3,
    'prpeditor' => 4,
    'csseditor' => 5,
    'tpleditor' => 6,
    'prp_css_selector' => 7,
    'html_editor' => 8,
    'js_editor' => 9,
    'php_editor' => 10,
    'html_js_php_selector' => 11,
    'msglist' => 12,
    'palette_page_selector' => 13,
    'palette_page_1' => 14,
    'palette_page_2' => 15,
    'frame' => 16,
    'palette' => 17,
    'page_edit_service' => 18,
    'TActionServer' => 19,
    'pageeditor' => 20,
    'pmodel' => 24,
    'pagelist' => 21,
    'newpage' => 25,
    'pageeditservice' => 26,
    'prgname' => 27,
    'allcmp' => 28,
    'changelog' => 29,
    'jq1_0a3' => 30,
    'servicehelp' => 31,
    'servicehelper_1' => 35,
    'mmodels' => 36,
    'mfields' => 37,
    'mfetchp' => 38,
    'mcmdp' => 39,
    'mcmd' => 40,
    'title' => 32,
    'briefmodels' => 33,
    'briefcommands' => 34,
    'fullmodels' => 41,
    'fullcommands' => 42,
    'mr' => 45,
    'palette_page_3' => 46,
    'pagetree.treemodel' => 50,
    'prpeditor.prpmodel' => 51,
    'csseditor.cssmodel' => 52,
    'tpleditor.tplmodel' => 53,
    'js_editor.jsmodel' => 54,
    'php_editor.phpmodel' => 55,
    'allcmp.model' => 56,
    'srvcompiler' => 57,
    'vidget_1' => 58,
    'TServiceController' => 59,
    'textspeededitor' => 60,
    'jq1_0a4' => 64,
    'linkscheckingdialog' => 65,
    'linkseditor' => 67,
    'linkseditor.model' => 66,
    'linkspeededitor' => 72,
    'linkspeededitor.mchild' => 68,
    'linkspeededitor.mlfield' => 69,
    'linkspeededitor.mservice' => 70,
    'linkspeededitor.mparent' => 71,
    'index' => 73,
    'logo' => 74,
    'menu' => 75,
    'shelp' => 76,
    'concept' => 77,
    'TDataBase' => 78,
    'TAccountService' => 79,
    'm_news' => 81,
    'news' => 82,
    'srv_news' => 80,
    'modelpagecontrol_1' => 83,
    'frm_new_news' => 84,
    'projects' => 85,
    'lib_ace' => 86,
  ),
  'classes' =>array (
    'TPage' =>array (
      0 => 'TContainer',
      1 => 'TVidget',
    ),
    'TComponentsTree' =>array (
      0 => 'TVidget',
    ),
    'TContainer' =>array (
      0 => 'TVidget',
    ),
    'TPrpEditor' =>array (
      0 => 'TVidget',
    ),
    'TCSSEditor' =>array (
      0 => 'TVidget',
    ),
    'TTplEditor' =>array (
      0 => 'TVidget',
    ),
    'TPageSelector' =>array (
      0 => 'TVidget',
    ),
    'TJsEditor' =>array (
      0 => 'TVidget',
    ),
    'TPHPEditor' =>array (
      0 => 'TVidget',
    ),
    'TVidget' =>array (
    ),
    'TPalettePage' =>array (
      0 => 'TVidget',
    ),
    'THTMLPreview' =>array (
      0 => 'TVidget',
    ),
    'TComponentsList' =>array (
      0 => 'TVidget',
    ),
    'TPageEditService' =>array (
      0 => 'TService',
    ),
    'TActionServer' =>array (
    ),
    'TModel' =>array (
    ),
    'TCacheModel' =>array (
      0 => 'TModel',
    ),
    'TServiceController' =>array (
      0 => 'TService',
    ),
    'TTextSpeedEditor' =>array (
      0 => 'TVidget',
    ),
    'TLinksCheckingDialog' =>array (
      0 => 'TVidget',
    ),
    'TComponentEditor' =>array (
      0 => 'TContainer',
      1 => 'TVidget',
    ),
    'TLinksEditor' =>array (
      0 => 'TVidget',
    ),
    'TLinkSpeedEditor' =>array (
      0 => 'TVidget',
    ),
    'TDataBase' =>array (
    ),
    'TAccountService' =>array (
      0 => 'TDBService',
      1 => 'TService',
    ),
    'TDiscussService' =>array (
      0 => 'TDBService',
      1 => 'TService',
    ),
    'TModelPageControl' =>array (
      0 => 'TVidget',
    ),
    'TForm' =>array (
      0 => 'TVidget',
    ),
    'TLibrary' =>array (
    ),
  ),
)
?>
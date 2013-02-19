<?
array (
  'components' =>array (
    0 =>array (
      'c' => 'TPage',
      'n' => 'index',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'title' =>array (
          0 => 'string',
          1 => 'Hello world',
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
      'u' =>array (
        0 => 25,
        1 => 12,
        2 => 5,
        3 => 30,
      ),
      's' =>array (
        0 =>array (
          0 => 1,
          1 => 27,
          2 => 26,
        ),
      ),
    ),
    1 =>array (
      'c' => 'TVidget',
      'n' => 'cap',
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
    5 =>array (
      'c' => 'TDataBase',
      'n' => 'TDataBase',
      'l' =>array (
        0 => 1,
        8 => 1,
        14 => 1,
      ),
      'p' =>array (
        'persistent' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    8 =>array (
      'c' => 'TPage',
      'n' => 'topics',
      'l' =>array (
        8 => 1,
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
          0 => 13,
          1 => 28,
          2 => 10,
          3 => 11,
          4 => 29,
        ),
      ),
      'u' =>array (
        0 => 25,
        1 => 12,
        2 => 5,
        3 => 21,
        4 => 9,
      ),
    ),
    9 =>array (
      'c' => 'TModel',
      'n' => 'mtopics',
      'l' =>array (
        8 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'srv_forum',
        ),
        'model' =>array (
          0 => 'string',
          1 => 'topics',
        ),
        'fields' =>array (
          0 => 'object',
          1 =>array (
            0 => 'title',
            1 => 'lastmsg.owner.name',
            2 => 'lastmsg.date',
            3 => 'msgcount',
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
    10 =>array (
      'c' => 'TVidget',
      'n' => 'vtopics',
      'l' =>array (
        8 => 1,
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
          1 => 'mtopics',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    11 =>array (
      'c' => 'TForm',
      'n' => 'frm_new_topic',
      'l' =>array (
        8 => 1,
      ),
      'p' =>array (
        'model' =>array (
          0 => 'component(TModel)',
          1 => 'mtopics',
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
    12 =>array (
      'c' => 'TActionServer',
      'n' => 'TActionServer',
      'l' =>array (
        8 => 1,
        14 => 1,
        0 => 1,
      ),
      'p' =>array (
      ),
    ),
    13 =>array (
      'c' => 'TLoginDialog',
      'n' => 'logindialog_1',
      'l' =>array (
        8 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 1,
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    14 =>array (
      'c' => 'TPage',
      'n' => 'discuss',
      'l' =>array (
        14 => 1,
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
          0 => 16,
          1 => 17,
          2 => 18,
          3 => 19,
        ),
      ),
      'u' =>array (
        0 => 25,
        1 => 12,
        2 => 5,
        3 => 20,
        4 => 15,
      ),
    ),
    15 =>array (
      'c' => 'TModel',
      'n' => 'mm',
      'l' =>array (
        14 => 1,
      ),
      'p' =>array (
        'service' =>array (
          0 => 'component(TService)',
          1 => 'srv_discuss',
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
            2 => 'owner.name',
            3 => 'subject.title',
            4 => 'parent',
          ),
        ),
        'first' =>array (
          0 => 'integer',
          1 => 0,
        ),
        'limit' =>array (
          0 => 'integer',
          1 => 5,
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
        'calcfields' =>array (
          0 => 'text',
          1 => 'own=isOwner(#owner)||isAdmin()',
        ),
      ),
    ),
    16 =>array (
      'c' => 'TVidget',
      'n' => 'vdiscuss',
      'l' =>array (
        14 => 1,
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
          1 => 'mm',
        ),
        'show_loader' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    17 =>array (
      'c' => 'TModelPageControl',
      'n' => 'pager',
      'l' =>array (
        14 => 1,
      ),
      'p' =>array (
        'model' =>array (
          0 => 'component(TModel)',
          1 => 'mm',
        ),
        'enabled' =>array (
          0 => 'boolean',
          1 => 1,
        ),
      ),
    ),
    18 =>array (
      'c' => 'TForm',
      'n' => 'newmsg',
      'l' =>array (
        14 => 1,
      ),
      'p' =>array (
        'model' =>array (
          0 => 'component(TModel)',
          1 => 'mm',
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
    19 =>array (
      'c' => 'TForm',
      'n' => 'editor',
      'l' =>array (
        14 => 1,
      ),
      'p' =>array (
        'model' =>array (
          0 => 'component(TModel)',
          1 => 'mm',
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
    20 =>array (
      'c' => 'TDiscussService',
      'n' => 'srv_discuss',
      'l' =>array (
        14 => 1,
      ),
      'p' =>array (
        'auth_required' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
      'links' =>array (
        0 =>array (
          'messages' =>array (
            'subject' =>array (
              0 => '21',
              1 => 'TForumService',
              2 => 'topics',
              3 => 'CASCADE',
            ),
            'owner' =>array (
              0 => '25',
              1 => 'TAccountService',
              2 => 'users',
              3 => 'NONE',
            ),
          ),
        ),
        1 =>array (
          'messages' =>array (
            0 =>array (
              0 => '21',
              1 => 'TForumService',
              2 => 'topics',
              3 => 'MAX',
              4 => 'subject',
              5 => 'idx',
              6 => 'lastmsg',
            ),
            1 =>array (
              0 => '21',
              1 => 'TForumService',
              2 => 'topics',
              3 => 'COUNT',
              4 => 'subject',
              5 => 'idx',
              6 => 'msgcount',
            ),
          ),
        ),
      ),
    ),
    21 =>array (
      'c' => 'TForumService',
      'n' => 'srv_forum',
      'l' =>array (
        8 => 1,
      ),
      'p' =>array (
      ),
      'r' =>array (
        'topics' =>array (
          'lastmsg' =>array (
            0 => 'INT UNSIGNED NOT NULL',
            1 =>array (
              0 => 20,
              1 => 'TDiscussService',
              2 => 'messages',
              3 => 'NONE',
            ),
          ),
          'msgcount' =>array (
            0 => 'INT UNSIGNED NOT NULL',
            1 => false,
          ),
        ),
      ),
      'links' =>array (
        0 =>array (
          'topics' =>array (
            'owner' =>array (
              0 => '25',
              1 => 'TAccountService',
              2 => 'users',
              3 => 'NONE',
            ),
          ),
        ),
        1 =>array (
        ),
      ),
    ),
    25 =>array (
      'c' => 'TAccountService',
      'n' => 'TAccountService',
      'l' =>array (
        0 => 1,
        8 => 1,
        14 => 1,
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
        'RSA_key_length' =>array (
          0 => 'list["256","512","1024"]',
          1 => '512',
        ),
      ),
    ),
    26 =>array (
      'c' => 'TRegistrationForm',
      'n' => 'regform',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    27 =>array (
      'c' => 'TVidget',
      'n' => 'vidget_1',
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
    28 =>array (
      'c' => 'TVidget',
      'n' => 'vidget_2',
      'l' =>array (
        8 => 1,
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
    29 =>array (
      'c' => 'TRegistrationForm',
      'n' => 'frm_registration',
      'l' =>array (
        8 => 1,
      ),
      'p' =>array (
        'display' =>array (
          0 => 'boolean',
          1 => 0,
        ),
      ),
    ),
    30 =>array (
      'c' => 'TForumService',
      'n' => 'forumservice_2',
      'l' =>array (
        0 => 1,
      ),
      'p' =>array (
      ),
    ),
  ),
  'names' =>array (
    'index' => 0,
    'cap' => 1,
    'TDataBase' => 5,
    'topics' => 8,
    'mtopics' => 9,
    'vtopics' => 10,
    'frm_new_topic' => 11,
    'TActionServer' => 12,
    'logindialog_1' => 13,
    'discuss' => 14,
    'mm' => 15,
    'vdiscuss' => 16,
    'pager' => 17,
    'newmsg' => 18,
    'editor' => 19,
    'srv_discuss' => 20,
    'srv_forum' => 21,
    'TAccountService' => 25,
    'vidget_1' => 27,
    'regform' => 26,
    'vidget_2' => 28,
    'frm_registration' => 29,
    'forumservice_2' => 30,
  ),
  'classes' =>array (
    'TPage' =>array (
      0 => 'TContainer',
      1 => 'TVidget',
    ),
    'TVidget' =>array (
    ),
    'TDataBase' =>array (
    ),
    'TModel' =>array (
    ),
    'TForm' =>array (
      0 => 'TVidget',
    ),
    'TActionServer' =>array (
    ),
    'TLoginDialog' =>array (
      0 => 'TVidget',
    ),
    'TModelPageControl' =>array (
      0 => 'TVidget',
    ),
    'TDiscussService' =>array (
      0 => 'TDBService',
      1 => 'TService',
    ),
    'TForumService' =>array (
      0 => 'TDBService',
      1 => 'TService',
    ),
    'TAccountService' =>array (
      0 => 'TDBService',
      1 => 'TService',
    ),
    'TRegistrationForm' =>array (
      0 => 'TForm',
      1 => 'TVidget',
    ),
  ),
)
?>
<?php

$contents = [
  'root' => '/',

  'routes' => [
    'home' => [
      'url' => '/',
      'type' => 'get',
      'name' => _('Home')
    ],

    'works' => [
      'url' => '/works',
      'type' => 'get',
      'name' => _('Works')
    ],

    'work' => [
      'url' => '/works/:id',
      'type' => 'get',
      'name' => _('Work'),
      'hide' => true // hide from navigation menu
    ],

    'resume' => [
      'url' => 'résumé', // in case of a file, the url is its name without its extension (see Router.php)
      'type' => 'file',
      'extension' => 'pdf',
      'name' => _('Résumé')
    ],

    'blog' => [
      'url' => 'http://blog.matthieu-bresson.com',
      'type' => 'external',
      'name' => _('Blog')
    ],

    'contact' => [
      'url' => '/contact',
      'type' => 'get',
      'name' => _('Contact')
    ],

    'contact_post' => [
      'url' => '/contact/post',
      'type' => 'post',
      'hide' => true
    ]
  ]
];

<?php

$contents = [
  'screenshots' => [
    [
      'src' => 'Demoshot.jpg',
      'alt' => '',
      'title' => _('A user\'s album page, with sorting buttons and pagination controls')
    ],
  ],

  'description' => '
    <p>' . _('Demoshot is a photo sharing website. Its users can (after signing up) upload photos, give marks and comment on other people\'s pictures. The photos can be associated with tags and easily managed in each user\'s album. Demoshot\'s UI is built upon Twitter Bootstrap. The underlying database management system is MySQL.') . '</p>

    <p>' . _('During my second year of undergraduate studies, the PHP teacher asked the students to develop a photo sharing website from scratch. Back then I was not very comfortable with PHP. As a result, it is not a project I\'m very proud to show: the overall architecture is messy and the code itself is not a pleasant read, even though it\'s commented. However, I\'m proud that I was able to develop my first complete website in a short time and all by myself. I have learnt a lot thanks to it.') . '</p>
  ',

  'tools' => [
    'PHP5',
    'Twitter Bootstrap',
    'jQuery',
    'MySQL'
  ],

  'links' => [
    'Demoshot-src.zip' => [
      'type' => 'file',
      'description' => _('Download the source code of Demoshot')
    ],

    'http://demoshot.matthieu-bresson.com' => [
      'type' => 'external',
      'description' => _('Check out the demo')
    ]
  ],

  'license' => 'MIT'
];


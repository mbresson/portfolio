<?php

$contents = [
  'screenshots' => [
    [
      'src' => 'Blockmatic-running.jpg',
      'alt' => '',
      'title' => _('Blockmatic after some tweaking')
    ],

    [
      'src' => 'Blockmatic-paused.jpg',
      'alt' => '',
      'title' => _('Blockmatic when paused')
    ]
  ],

  'description' => '
    <p>' . _('Blockmatic is a highly configurable Tetris clone. You can tweak it via the command line interface (blockmatic --help for the list of all available options).') . '</p>

    <p>' . _('I\'m an unconditional fan of Tetris and I wanted to have a game that I could adapt to my needs. It was also a great opportunity to discover the SDL2 library for game development.') . '</p>
  ',

  'tools' => [
    _('C programming language'),
    _('SDL2 library')
  ],

  'links' => [
    'Blockmatic-src.zip' => [
      'type' => 'file',
      'description' => _('Download the source code of Blockmatic')
    ],

    'Blockmatic-Windows_Build.zip' => [
      'type' => 'file',
      'description' => _('Download Blockmatic for Windows')
    ],

    'Blockmatic-Linux_Build_i686.zip' => [
      'type' => 'file',
      'description' => _('Download Blockmatic for Linux (32 bits)')
    ],

    'Blockmatic-Linux_Build_x86_64.zip' => [
      'type' => 'file',
      'description' => _('Download Blockmatic for Linux (64 bits)')
    ]
  ],

  'license' => 'GNU GPLv3'
];


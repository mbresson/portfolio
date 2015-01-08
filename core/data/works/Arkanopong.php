<?php

$contents = [
  'screenshots' => [
    [
      'src' => 'Arkanopong-in-game.jpg',
      'alt' => '',
      'title' => _('A level in Arkanopong')
    ],

    [
      'src' => 'Arkanopong-menu.png',
      'alt' => '',
      'title' => _('The main menu allows you to change some settings and to select the level to play')
    ]
  ],

  'description' => '
    <p>' . _('Arkanopong is a mix between Ping Pong and Bricks Breaking games. You can play with another human or against the computer (its IA is basic but does the job).') . '</p>

    <p>' . _('Arkanopong uses OpenGL 2 and its fixed function pipeline for the rendering. It may run on any platform supported by OpenGL2 and the SDL library (which is used to create the window and capture events).') . '</p>

    <p>' . _('This project was fun to work on but if I could re-write it, I\'d do it differently. The biggest difficulty I ran into was to render text. At first, I intended to render the text with Freetype library, but due to the strict deadline I didn\'t have time to learn how to use it. In the end, since all the text in the game is fixed and never changes, I chose to render it with SDL_image and then convert it to hardware textures.') . '</p>
  ',

  'tools' => [
    _('C programming language'),
    'OpenGL 2',
    _('SDL library')
  ],

  'links' => [
    'Arkanopong-src.zip' => [
      'type' => 'file',
      'description' => _('Download the source code of Arkanopong')
    ],

    'Arkanopong-rapport.pdf' => [
      'type' => 'file',
      'description' => _('Download the work report I had to write for my teacher (it\'s only in French)')
    ]
  ],

  'license' => 'GNU GPLv3'
];


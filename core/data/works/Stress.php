<?php

$contents = [
  'description' => '
    <p>' . _('Stress is an attempt to create a short (2-minute-long) music about stress and losing control. The music consists of three parts: the rise of stress, an attempt to cool down and lastly, the failure and the final collapse.') . '</p>

    <p>' . _('Stress was created using Protools and its plugin Xpand2. Most of the work consisted in editing MIDI tracks.') . '</p>
  ',

  'content' => [
    'audio' => [
      'description' => _('Listen to Stress:'),

      'src' => [
        'stress.ogg' => 'audio/ogg',
        'stress.mp3' => 'audio/mpeg'
      ]
    ]
  ],

  'tools' => [
    'Protools'
  ],

  'links' => [
    'stress-protools.zip' => [
      'type' => 'file',
      'description' => _('Download the Protools project directory')
    ],
  ],

  'license' => 'CC BY-SA 4.0'
];


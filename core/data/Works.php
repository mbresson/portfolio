<?php

$contents = [
  'categories' => [
    'programming' => [
      'name' => _('Programming'),
      'description' => _('Software and website development.'),
      'view' => 'programming'
    ],

    'artistic' => [
      'name' => _('Artistic'),
      'description' => _('Artistic works (images, music, etc).'),
      'view' => 'artistic'
    ],

    'photo' => [
      'name' => _('Photo albums'),
      'description' => _('Photos from trips and everyday life.'),
      'view' => 'photo'
    ],

    'misc' => [
      'name' => _('Miscellaneous'),
      'description' => _('Other works...'),
      'view' => 'misc'
    ]
  ],

  'licenses' => [
    'GNU GPLv3' => [
      'name' => _('GNU GPLv3'),
      'href' => 'http://www.gnu.org/licenses/gpl-3.0.html'
    ],

    'WTFPL' => [
      'name' => _('WTFPL'),
      'href' => 'http://www.wtfpl.net/'
    ],

    'MIT' => [
      'name' => _('MIT'),
      'href' => 'http://opensource.org/licenses/MIT'
    ],

    'CC BY-SA 4.0' => [
      'name' => _('CC BY-SA 4.0'),
      'href' => 'http://creativecommons.org/licenses/by-sa/4.0/'
    ]
  ],

  'works' => [
    'Blockmatic' => [
      'category' => 'programming',
      'name' => 'Blockmatic',
      'summary' => _('A highly configurable Tetris clone'),
      
      'filters' => [
        'school_project' => false
      ]
    ],

    'Arkanopong' => [
      'category' => 'programming',
      'name' => 'Arkanopong',
      'summary' => _('A mix between Ping Pong and Bricks Breaking games'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Polynomials' => [
      'category' => 'programming',
      'name' => 'Polynomials',
      'summary' => _('A very basic C library for the handling of polynomials'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Demoshot' => [
      'category' => 'programming',
      'name' => 'Demoshot',
      'summary' => _('A photo sharing website'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Bareview' => [
      'category' => 'programming',
      'name' => 'Bareview',
      'summary' => _('A theme for PluXML blogs'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Portfolio' => [
      'category' => 'programming',
      'name' => 'matthieu-bresson.com',
      'summary' => _('My portfolio website which you\'re currently browsing!'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Moonlight-Champa' => [
      'category' => 'programming',
      'name' => 'Moonlight Champa',
      'summary' => _('The website of Moonlight Champa guesthouse, Vientiane, Lao PDR'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Laos-2013' => [
      'category' => 'photo',
      'name' => _('Laos 2013'),
      'summary' => _('Photos shot in Vientiane and Luang Prabang, Lao PDR'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Korea-2012' => [
      'category' => 'photo',
      'name' => _('Korea 2012'),
      'summary' => _('Photos shot in South Korea during my summer school at Chonbuk National University'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Beijing-2013' => [
      'category' => 'photo',
      'name' => _('Beijing 2013'),
      'summary' => _('Photos shot when doing a four-month internship in Beijing'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Berlin-2014' => [
      'category' => 'photo',
      'name' => _('Berlin 2014'),
      'summary' => _('Photos shot during a short trip to Berlin'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'France' => [
      'category' => 'photo',
      'name' => _('France'),
      'summary' => _('Photos shot over the years in France'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Thailand-2014' => [
      'category' => 'photo',
      'name' => _('Thailand 2014'),
      'summary' => _('Photos shot in Thailand in 2014'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Other-pictures' => [
      'category' => 'photo',
      'name' => _('Other pictures'),
      'summary' => _('Miscellaneous pictures'),

      'filters' => [
        'school_project' => false
      ]
    ],

    'Stress' => [
      'category' => 'artistic',
      'name' => _('Stress'),
      'summary' => _('A short audio work trying to depict the rise of stress'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Apartom' => [
      'category' => 'artistic',
      'name' => _('Apartom'),
      'summary' => _('A picture about a man and a woman who are apart even though they\'re sitting close to each other'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Blazon' => [
      'category' => 'artistic',
      'name' => _('Blazon'),
      'summary' => _('A visual description of my values and my roots'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Rapport-Schwann' => [
      'category' => 'misc',
      'name' => _('Schwann internship report'),
      'summary' => _('A report on my four-month internship at Schwann'),

      'filters' => [
        'school_project' => true
      ]
    ],

    'Refonte-Soleilprod' => [
      'category' => 'misc',
      'name' => _('Overhaul plan for Soleilprod'),
      'summary' => _('An overhaul plan for soleilprod.com website'),

      'filters' => [
        'school_project' => true
      ]
    ]
  ]
];

<?php
return [
    'groups' => [
        'looks' => [
            'title' => __tr('Looks'),
            'icon'  => '<i class="far fa-smile text-primary"></i>',
            'items' => [
                'ethnicity' => [
                    'name'          => __tr('Ethnicity'),
                    'input_type'    => 'select',
                    'options' => [
                        'white'             => __tr('White'),
                        'black'             => __tr('Black'),
                        'middle_eastern'    => __tr('Middle Eastern'),
                        'north_african'     => __tr('North African'),
                        'latin_american'    => __tr('Latin American'),
                        'mixed'             => __tr('Mixed'),
                        'asian'             => __tr('Asian'),
                        'other'             => __tr('Other'),
                    ]
                ],
                'body_type' => [
                    'name'          => __tr('Body Type'),
                    'input_type'    => 'select',
                    'options' => [
                        'slim'          => __tr('Slim'),
                        'sporty'        => __tr('Sporty'),
                        'curvy'         => __tr('Curvy'),
                        'round'         => __tr('Round'),
                        'supermodel'    => __tr('Supermodel'),
                        'average'       => __tr('Average'),
                        'other'         => __tr('Other')
                    ]
                ],
                'height' => [
                    'name' => __tr('Height'),
                    'input_type'    => 'select',
                    'options' => [
                        "139"            => "139 cm",
                        "140"     => "140 cm (4' 7″)",
                        "141"            => "141 cm",
                        "142"     => "142 cm (4' 8″)",
                        "143"            => "143 cm",
                        "144"            => "144 cm",
                        "145"     => "145 cm (4' 9″)",
                        "146"            => "146 cm",
                        "147"    => "147 cm (4' 10″)",
                        "148"            => "148 cm",
                        "149"            => "149 cm",
                        "150"    => "150 cm (4' 11″)",
                        "151"            => "151 cm",
                        "152"     => "152 cm (5' 0″)",
                        "153"            => "153 cm",
                        "154"            => "154 cm",
                        "155"     => "155 cm (5' 1″)",
                        "156"            => "156 cm",
                        "157"     => "157 cm (5' 2″)",
                        "158"            => "158 cm",
                        "159"            => "159 cm",
                        "160"     => "160 cm (5' 3″)",
                        "161"            => "161 cm",
                        "162"            => "162 cm",
                        "163"     => "163 cm (5' 4″)",
                        "164"            => "164 cm",
                        "165"     => "165 cm (5' 5″)",
                        "166"            => "166 cm",
                        "167"            => "167 cm",
                        "168"     => "168 cm (5' 6″)",
                        "169"            => "169 cm",
                        "170"     => "170 cm (5' 7″)",
                        "171"            => "171 cm",
                        "172"            => "172 cm",
                        "173"     => "173 cm (5' 8″)",
                        "174"            => "174 cm",
                        "175"     => "175 cm (5' 9″)",
                        "176"            => "176 cm",
                        "177"            => "177 cm",
                        "178"    => "178 cm (5' 10″)",
                        "179"            => "179 cm",
                        "180"    => "180 cm (5' 11″)",
                        "181"            => "181 cm",
                        "182"            => "182 cm",
                        "183"     => "183 cm (6' 0″)",
                        "184"            => "184 cm",
                        "185"     => "185 cm (6' 1″)",
                        "186"            => "186 cm",
                        "187"            => "187 cm",
                        "188"     => "188 cm (6' 2″)",
                        "189"            => "189 cm",
                        "190"            => "190 cm",
                        "191"     => "191 cm (6' 3″)",
                        "192"            => "192 cm",
                        "193"     => "193 cm (6' 4″)",
                        "194"            => "194 cm",
                        "195"            => "195 cm",
                        "196"     => "196 cm (6' 5″)",
                        "197"            => "197 cm",
                        "198"     => "198 cm (6' 6″)",
                        "199"            => "199 cm",
                        "200"            => "200 cm",
                        "201"     => "201 cm (6' 7″)",
                        "202"            => "202 cm",
                        "203"     => "203 cm (6' 8″)",
                        "204"            => "204 cm",
                        "205"            => "205 cm",
                        "206"     => "206 cm (6' 9″)",
                        "207"            => "207 cm",
                        "208"    => "208 cm (6' 10″)",
                        "209"            => "209 cm",
                        "210"            => "210 cm",
                        "211"    => "211 cm (6' 11″)",
                        "212"            => "212 cm",
                        "213"     => "213 cm (7' 0″)",
                        "214"            => "214 cm",
                        "215"            => "215 cm",
                        "216"     => "216 cm (7' 1″)",
                        "217"            => "217 cm",
                        "218"            => "218 cm",
                        "220"     => "220 cm (7' 3″)",
                    ]
                ],
                'hair_color' => [
                    'name'          => __tr('Hair Color'),
                    'input_type'    => 'select',
                    'options'   => [
                        'brown'                     => __tr('Marrom'),
                        'black'                     => __tr('Preto'),
                        'white'                     => __tr('Branco'),
                        'sandy'                     => __tr('Sandy'),
                        'gray_or_partially_gray'    => __tr('Gray or Partially Gray'),
                        'red/auburn'                => __tr('Ruivo'),
                        'blond/strawberry'          => __tr('Loiro'),
                        'blue'                      => __tr('Blue'),
                        'green'                     => __tr('Green'),
                        'orange'                    => __tr('Laranja'),
                        'pink'                      => __tr('Pink'),
                        'purple'                    => __tr('Purple'),
                        'partly_or_completely_bald' => __tr('Careca ou parcialmente careca'),
                        'other'                     => __tr('Other')
                    ]
                ],
                'eye_color' => [
                    'name'          => __tr('Cor dos olhos'),
                    'input_type'    => 'select',
                    'options'   => [
                        'brow'                => __tr('Castanhos'),
                        'black'                     => __tr('Pretos'),
                        'blue'                      => __tr('Azuis'),
                        'green'                     => __tr('Verdes'),
                    ]
                ]
            ]
        ],
        'personality' => [
            'title' => __tr('Personality'),
            'icon'  => '<i class="fas fa-child text-success"></i>',
            'items' => [
                'nature' => [
                    'name'          => __tr('Nature'),
                    'input_type'    => 'select',
                    'options' => [
                        'accommodating'     => __tr('Acomodado'),
                        'adventurous'       => __tr('Adventurous'),
                        'calm'              => __tr('Calm'),
                        'careless'          => __tr('Careless'),
                        'cheerful'          => __tr('Cheerful'),
                        'demanding'         => __tr('Demanding'),
                        'extroverted'       => __tr('Extroverted'),
                        'honest'            => __tr('Honest'),
                        'generous'          => __tr('Generous'),
                        'humorous'          => __tr('Humorous'),
                        'introverted'       => __tr('Introverted'),
                        'liberal'           => __tr('Liberal'),
                        'lively'            => __tr('Lively'),
                        'loner'             => __tr('Loner'),
                        'nervous'           => __tr('Nervous'),
                        'possessive'        => __tr('Possessive'),
                        'quiet'             => __tr('Quiet'),
                        'reserved'          => __tr('Reserved'),
                        'sensitive'         => __tr('Sensitive'),
                        'shy'               => __tr('Shy'),
                        'social'            => __tr('Social'),
                        'spontaneous'       => __tr('Spontaneous'),
                        'stubborn'          => __tr('Stubborn'),
                        'suspicious'        => __tr('Suspicious'),
                        'thoughtful'        => __tr('Thoughtful'),
                        'proud'             => __tr('Proud'),
                        'considerate'       => __tr('Considerate'),
                        'friendly'          => __tr('Friendly'),
                        'polite'            => __tr('Polite'),
                        'reliable'          => __tr('Reliable'),
                        'careful'           => __tr('Careful'),
                        'helpful'           => __tr('Helpful'),
                        'patient'           => __tr('Patient'),
                        'optimistic'        => __tr('Optimistic')
                    ]
                ],
                'friends' => [
                    'name'          => __tr('Friends'),
                    'input_type'    => 'select',
                    'options' => [
                        'no_friends'        => __tr('No friends'),
                        'some_friends'      => __tr('Some friends'),
                        'many_friends'      => __tr('Many friends'),
                        'only_good_friends' => __tr('Only good friends'),
                    ]
                ],
                'children' => [
                    'name'          => __tr('Children'),
                    'input_type'    => 'select',
                    'options' => [
                        "no_never"                          => __tr("No, never"),
                        "someday_maybe"                     => __tr("Someday, maybe"),
                        "expecting"                         => __tr("Expecting"),
                        "i_already_have_kids"               => __tr("already have kids"),
                        "i_have_kids_and_don't_want_more"   => __tr("have kids and don't want more")
                    ]
                ],
                'pets' => [
                    'name'          => __tr('Pets'),
                    'input_type'    => 'select',
                    'options' => [
                        'none'      => __tr('Nenhum'),
                        'have_pets' => __tr('Tenho animais de estimação')
                    ]
                ]
            ]
        ],
        'lifestyle' => [
            'title' => __tr('Lifestyle'),
            'icon'  => '<i class="fas fa-umbrella-beach text-warning"></i>',
            'items' => [
                'religion' => [
                    'name'          => __tr('Religion'),
                    'input_type'    => 'select',
                    'options' => [
                        'muslim'        => __tr('Muslim'),
                        'atheist'       => __tr('Atheist'),
                        'buddhist'      => __tr('Buddhist'),
                        'catholic'      => __tr('Catholic'),
                        'christian'     => __tr('Christian'),
                        'hindu'         => __tr('Hindu'),
                        'jewish'        => __tr('Jewish'),
                        'agnostic'      => __tr('Agnostic'),
                        'sikh'          => __tr('Sikh'),
                        'other'         => __tr('Other')
                    ]
                ],
                'i_live_with' => [
                    'name'          => __tr('I live with'),
                    'input_type'    => 'select',
                    'options' => [
                        'alone'     => __tr('Sozinho(a)'),
                        'family'   => __tr('Família'),
                        'parents'   => __tr('Parents'),
                        'friends'   => __tr('Amigos(as)'),
                        'partner'   => __tr('Parceiro(a)'),
                        'children'  => __tr('Children'),
                        'other'     => __tr('Other')
                    ]
                ],
                'car' => [
                    'name'          => __tr('Car'),
                    'input_type'    => 'select',
                    'options' => [
                        'none' => __tr('None'),
                        'my_own_car' => __tr('My Own Car')
                    ]
                ],
                'travel' => [
                    'name'          => __tr('Travel'),
                    'input_type'    => 'select',
                    'options' => [
                        "yes_all_the_time"  => __tr("Yes, all the time"),
                        "yes_sometimes"     => __tr("Yes, sometimes"),
                        "not_very_much"     => __tr("Not very much"),
                        "no"                => __tr("No")
                    ]
                ],
                'smoke' => [
                    'name'          => __tr('Smoke'),
                    'input_type'    => 'select',
                    'options' => [
                        'never'             => __tr('No'),
                        'i_some_sometimes'  => __tr('Yes'),
                        // 'chain_smoker'      => __tr('Chain Smoker')
                    ]
                ],
                'drink' => [
                    'name'          => __tr('Drink'),
                    'input_type'    => 'select',
                    'options' => [
                        'never' => __tr('Não bebo'),
                        'i_drink_sometimes' => __tr('Bebo socialmente'),
                        'i_drink_always' => __tr('Gosto muito')

                    ]
                ],
            ]
        ],
        'favorites' => [
            'title' => __tr('Favorites'),
            'icon'  => '<i class="far fa-heart text-danger"></i>',
            'items' => [
                'music_genre' => [
                    'name'          => __tr('Music Genre'),
                    'input_type'    => 'textbox'
                ],
                'singer' => [
                    'name'          => __tr('Singer'),
                    'input_type'    => 'textbox'
                ],
                'song' => [
                    'name'          => __tr('Song'),
                    'input_type'    => 'textbox'
                ],
                'hobby' => [
                    'name'          => __tr('Hobby'),
                    'input_type'    => 'textbox'
                ],
                'sport' => [
                    'name'          => __tr('Sport'),
                    'input_type'    => 'textbox'
                ],
                'book' => [
                    'name'          => __tr('Book'),
                    'input_type'    => 'textbox'
                ],
                'dish' => [
                    'name'          => __tr('Dish'),
                    'input_type'    => 'textbox'
                ],
                'color' => [
                    'name'          => __tr('Color'),
                    'input_type'    => 'textbox'
                ],
                'movie' => [
                    'name'          => __tr('Movie'),
                    'input_type'    => 'textbox'
                ],
                // 'show' => [
                //     'name'          => __tr('Show'),
                //     'input_type'    => 'textbox'
                // ],
                // 'inspired_from' => [
                //     'name'          => __tr('Inspired From'),
                //     'input_type'    => 'textbox'
                // ]
            ]
        ],
    ]
];
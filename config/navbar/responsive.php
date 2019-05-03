<?php
/**
 * Supply the basis for the navbar as an array.
 */
return [
    // Use for styling the menu
    "id" => "rm-menu",
    "wrapper" => null,
    "class" => "rm-default rm-mobile",

    // Here comes the menu items
    "items" => [
        [
            "text" => "Hem",
            "url" => "",
            "title" => "Första sidan, börja här.",
        ],
        [
            "text" => "Redovisning",
            "url" => "redovisning",
            "title" => "Redovisningstexter från kursmomenten.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Kmom01",
                        "url" => "redovisning/kmom01",
                        "title" => "Redovisning för kmom01.",
                    ],
                    [
                        "text" => "Kmom02",
                        "url" => "redovisning/kmom02",
                        "title" => "Redovisning för kmom02.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Om",
            "url" => "om",
            "title" => "Om denna webbplats.",
        ],
        [
            "text" => "Spel",
            "url" => "dice-game",
            "title" => "Spela spel.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Guess Game",
                        "url" => "guess-game",
                        "title" => "Gissa-nummretspel.",
                    ],
                    [
                        "text" => "Tärningsspel",
                        "url" => "dice-game",
                        "title" => "Tärningsspelet 100.",
                    ],
                ],
            ],
        ],
        [
            "text" => "Övrigt",
            "url" => "dokumentation",
            "title" => "Övrigt.",
            "submenu" => [
                "items" => [
                    [
                        "text" => "Docs",
                        "url" => "dokumentation",
                        "title" => "Dokumentation av ramverk och liknande.",
                    ],
                    [
                        "text" => "Test &amp; Lek",
                        "url" => "lek",
                        "title" => "Testa och lek med test- och exempelprogram",
                    ],
                    [
                        "text" => "Anax dev",
                        "url" => "dev",
                        "title" => "Anax development utilities",
                    ],
                    [
                        "text" => "Styleväljare",
                        "url" => "style",
                        "title" => "Välj stylesheet.",
                    ],
                ],
            ],
        ],
    ],
];

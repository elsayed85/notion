# This is my package For Notion Api

## Installation

You can install the package via composer:

```bash
composer require elsayed85/notion
```

You can publish the config file with:

```bash
php artisan vendor:publish --provider="Elsayed85\Notion\NotionServiceProvider" --tag="notion-config"
```

This is the contents of the published config file:

```php
return [
    "base" => "https://api.notion.com",
    'version' => '2021-05-13'
];
```

Add Notion Api To your env

in config/services.php
```
'notion' => [
        'client_id' => env('NOTION_CLIENT_ID'),
        'client_secret' => env('NOTION_CLIENT_SECRET'),
        'token' => env('NOTION_TOKEN')
]
```

in .env add 
```
# for public
NOTION_CLIENT_ID=
NOTION_CLIENT_SECRET=

# for internal
NOTION_TOKEN=
```


## Usage

```php
$notion = new Elsayed85\Internal\Notion();

$start_cursor = null;
$page_size = 20;

// https://developers.notion.com/reference/get-databases
$notion->databases($start_cursor , $page_size);

// https://developers.notion.com/reference/post-database-query
$notion->queryDatabase("2f611956-c64b-4588-ab64-2f013ac42527");

// https://developers.notion.com/reference/get-database
$notion->database("2f611956-c64b-4588-ab64-2f013ac42527");

// https://developers.notion.com/reference/get-users
$notion->users();

// https://developers.notion.com/reference/get-user
 $notion->user("73e41e87-0ae2-4ef0-bd21-a9d352c07a47");

 // https://developers.notion.com/reference/post-search
 $notion->search("hassan", 'last_edited_time');


// https://developers.notion.com/reference/get-page
 $notion->page("cdd93f5f-1626-4388-9a02-78779663a3aa")

// https://developers.notion.com/reference/post-page
 $notion->createPage(
        "2f611956-c64b-4588-ab64-2f013ac42527",
        "database_id",
        [
            'Name' => [
                'title' => [
                    0 => [
                        'text' => [
                            'content' => 'Tuscan Kale',
                        ],
                    ],
                ],
            ],
            'Email' => [
                'email' => "test@gmail.com",
            ],
        ],
        [
            0 => [
                'object' => 'block',
                'type' => 'heading_2',
                'heading_2' => [
                    'text' => [
                        0 => [
                            'type' => 'text',
                            'text' => [
                                'content' => 'Lacinato kale',
                            ],
                        ],
                    ],
                ],
            ],
            1 => [
                'object' => 'block',
                'type' => 'paragraph',
                'paragraph' => [
                    'text' => [
                        0 => [
                            'type' => 'text',
                            'text' => [
                                'content' => 'Lacinato kale is a variety of kale with a long tradition in Italian cuisine, especially that of Tuscany. It is also known as Tuscan kale, Italian kale, dinosaur kale, kale, flat back kale, palm tree kale, or black Tuscan palm.',
                                'link' => [
                                    'url' => 'https://en.wikipedia.org/wiki/Lacinato_kale',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    );


// https://developers.notion.com/reference/patch-page
     $notion->updatePage(
        "cdd93f5f-1626-4388-9a02-78779663a3aa",
        [
            'Name' => [
                'title' => [
                    0 => [
                        'text' => [
                            'content' => 'Tuscan Kale',
                        ],
                    ],
                ],
            ],
            'Email' => [
                'email' => "test@gmail.com",
            ],
        ],
        [
            0 => [
                'object' => 'block',
                'type' => 'heading_2',
                'heading_2' => [
                    'text' => [
                        0 => [
                            'type' => 'text',
                            'text' => [
                                'content' => 'Lacinato kale',
                            ],
                        ],
                    ],
                ],
            ],
            1 => [
                'object' => 'block',
                'type' => 'paragraph',
                'paragraph' => [
                    'text' => [
                        0 => [
                            'type' => 'text',
                            'text' => [
                                'content' => 'Lacinato kale is a variety of kale with a long tradition in Italian cuisine, especially that of Tuscany. It is also known as Tuscan kale, Italian kale, dinosaur kale, kale, flat back kale, palm tree kale, or black Tuscan palm.',
                                'link' => [
                                    'url' => 'https://en.wikipedia.org/wiki/Lacinato_kale',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ]
    );
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [elsayed85](https://github.com/elsayed85)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

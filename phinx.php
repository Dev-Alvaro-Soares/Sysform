<?php
// LEGADO: configuração do Phinx mantida apenas para referência.
// O esquema atual do banco foi criado manualmente e as migrations
// não estão sendo executadas neste projeto no momento.
return [
    'paths' => [
        'migrations' => 'db/migrations',
        'seeds' => 'db/seeds'
    ],
    'environments' => [
        'default_migration_table' => 'phinxlog',
        'default_environment' => 'development',
        'development' => [
            'adapter' => 'pgsql',
            'host' => '192.168.123.32',
            'name' => 'militar',
            'user' => 'militar',
            'pass' => 'forms3Mil',
            'port' => '5432',
            'charset' => 'utf8',
            'schema' => 'forms_militar'
        ]
    ]
];

<?php

return [
    'disk' => 'local',
    'table' => 'uploads',

    /*
     * Hash files and compare them to pre-existing files in the database
     */
    'hash' => [
        /*
         * On or off
         */
        'enabled' => true,

        /*
         * The hashing algorithm
         */
        'algo' => 'sha256',
    ]
];

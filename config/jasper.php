<?php

return [
    'jrs_base_url' => env('JRS_BASE_URL', 'http://127.0.0.1:8080/jasperserver'),
    'jrs_username' => env('JRS_USERNAME', 'jasperadmin'),
    'jrs_password' => env('JRS_PASSWORD', 'jasperadmin'),
    'jrs_folder' => env('JRS_FOLDER', '/reports'),
    'jrs_org_id' => env('JRS_ORG_ID', null),
    'timeout' => env('JRS_TIMEOUT', 10),
];

<?php

return [
    'googletoken' => [ // Đây là ten của token, bạn có thể tạo nhiều loại khác nhau
        'client_path' => storage_path('google/credentials.json'),
        'token_path' => storage_path('google/token.json'),
        'scopes' => [
            \Google_Service_Sheets::SPREADSHEETS
        ]
    ]
];
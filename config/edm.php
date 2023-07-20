<?php

// config for AtakanAtici/EDM
return [
    'edm_webservice' => env('EDM_WEBSERVICE', 'https://test.edmbilisim.com.tr/EFaturaEDM21ea/EFaturaEDM.svc?singleWsdl'),
    'edm_username' => env('EDM_USERNAME', 'Datanet'),
    'edm_password' => env('EDM_PASSWORD', '1234567'),

    'senaryo' => [
        'TICARIFATURA' => 'Ticari Fatura',
        'TEMELFATURA' => 'Temel Fatura',
    ],
    'fatura_tur' => [
        'SATIS' => 'Satış',
    ],
    'cari_tur' => [
        'TUZELKISI' => 'Tüzel Kişi',
        'GERCEKKISI' => 'Gerçek Kişi',
    ],
];

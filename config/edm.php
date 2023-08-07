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
    "fatura_tur" => [
        'SATIS' => 'Satış',
    ],
    "cari_tur" => [
        "TUZELKISI" => "Tüzel Kişi",
        "GERCEKKISI" => "Gerçek Kişi",
    ],
    "fatura_durum" => [
        "0" => "Gönderilemedi",
        "1" => "Gönderildi",
    ],
    "fatura_durum_renk" => [
        "0" => "danger",
        "1" => "success",
    ],

    "fatura_odeme_sekli" => [
        "NAKIT" => "Nakit",
        "KREDIKARTI" => "Kredi Kartı",
        "CEK" => "Çek",
        "SENET" => "Senet",
        "DIGER" => "Diğer",
    ],


];

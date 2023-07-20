<?php

namespace AtakanAtici\EDM\Classes;

class Util
{
    public static $service_url = 'https://test.edmbilisim.com.tr/EFaturaEDM21ea/EFaturaEDM.svc?singleWsdl';

    public static function GUID()
    {
        if (function_exists('com_create_guid') === true) {
            return trim(com_create_guid(), '{}');
        }

        return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    public static function actionDate()
    {
        return date('Y-m-d').'T'.date('H:i:s');
    }

    public static function issueDate()
    {
        return date('Y-m-d');
    }

    public static function issueTime()
    {
        return date('H:i:s');
    }

    public static function formatDecimal($sayi, $basamak = 3)
    {
        return number_format($sayi, $basamak, '.', '');
    }

    public static function invoiceStatus($statusCode)
    {
        $statusCode = str_replace(' ', '', $statusCode);
        $durum = [
            'PACKAGE-PROCESSING' => ['aciklama' => 'Zarflama yapılıyor', 'yap' => 'BEKLE'],
            'SEND-PROCESSING' => ['aciklama' => 'Gönderim İşlemi Devam Ediyor', 'yap' => 'BEKLE'],
            'SEND-WAIT_GIB_RESPONSE' => ['aciklama' => 'Gönderim İşlemi Devam Ediyor', 'yap' => 'BEKLE'],
            'SEND-WAIT_SYSTEM_RESPONSE' => ['aciklama' => 'Gönderim İşlemi Devam Ediyor', 'yap' => 'BEKLE'],
            'REJECT-PROCESSING' => ['aciklama' => 'RED Yanıtı Gönderiliyor', 'yap' => 'BEKLE'],
            'REJECT-WAIT_GIB_RESPONSE' => ['aciklama' => 'RED Yanıtı Gönderiliyor', 'yap' => 'BEKLE'],
            'REJECT-WAIT_SYSTEM_RESPONSE' => ['aciklama' => 'RED Yanıtı Gönderiliyor', 'yap' => 'BEKLE'],
            'ACCEPT-PROCESSING' => ['aciklama' => 'KABUL Yanıtı Gönderiliyor', 'yap' => 'BEKLE'],
            'ACCEPT-WAIT_GIB_RESPONSE' => ['aciklama' => 'KABUL Yanıtı Gönderiliyor', 'yap' => 'BEKLE'],
            'ACCEPT-WAIT_SYSTEM_RESPONSE' => ['aciklama' => 'Kabul Yanıtı Gönderiliyor', 'yap' => 'BEKLE'],
            'SEND-WAIT_APPLICATION_RESPONSE' => ['aciklama' => 'Yanıt Bekleniyor', 'yap' => 'BEKLE'],
            'UNKNOWN-UNKNOWN' => ['aciklama' => 'Belirsiz Durum - İşlem Devam Ediyor', 'yap' => 'BEKLE'],
            'RECEIVE-WAIT_SYSTEM_RESPONSE' => ['aciklama' => 'Sistem Tarafından Yanıt Bekleniyor', 'yap' => 'BEKLE'],

            'RECEIVE-SUCCEED' => ['aciklama' => 'Temel Fatura Başarı İle Alındı', 'yap' => 'ICERIAL'],
            'ACCEPT-SUCCEED' => ['aciklama' => 'KABUL Yanıtı Gönderildi.', 'yap' => 'ICERIAL'],

            'SEND-SUCCEED' => ['aciklama' => 'Fatura Alıcı Tarafından Onaylandı', 'yap' => 'KABULET'],
            'ACCEPTED-SUCCEED' => ['aciklama' => 'Fatura Onaylandı.', 'yap' => 'KABULET'],

            'RECEIVE-WAIT_APPLICATION_RESPONSE' => ['aciklama' => 'Kabul veya Red Yanıtı Bekleniyor', 'yap' => 'KABULRED'],
            'ACCEPT-FAILED' => ['aciklama' => 'KABUL Yanıtı İletilemedi. Yeniden Gönder', 'yap' => 'KABULRED'],
            'REJECT-FAILED' => ['aciklama' => 'RED Yanıtı İletilemedi. Yeniden Gönderin', 'yap' => 'KABULRED'],

            'REJECTED-SUCCEED' => ['aciklama' => 'Fatura Red Edildi.', 'yap' => 'REDET'],
            'REJECT-SUCCEED' => ['aciklama' => 'RED Yanıtı Gönderildi. Faturayı İptal Edin', 'yap' => 'REDET'],

            'PACKAGE-FAIL' => ['aciklama' => 'Zarflamada Hata Alındı', 'yap' => 'RESEND'],
            'SEND-FAILED' => ['aciklama' => 'Gönderim İşlemi Hatalı Bitti, Gönderilemedi', 'yap' => 'RESEND'],
        ];

        return $durum[trim($statusCode)];
    }

    public static function localInvoiceStatus($statusCode)
    {
        $durum = [
            '0' => 'EFatura Aktif Değil',
            '1' => 'Gönderim Bekliyor',
            '2' => 'Gönderildi.Giden Kutusuna Bakın',
        ];

        return $durum[$statusCode];
    }

    public static function UBLClear($xmlStr)
    {
        $xmlStr = preg_replace("/<Invoice ([a-z][a-z0-9]*)[^>]*?(\/?)>/i", ' <Invoice>', $xmlStr);
        $xmlStr = str_replace(['cbc:', 'cac:', 'ext:', 'ds:', 'xades:'], ['', '', '', '', ''], $xmlStr);

        return $xmlStr;
    }
}

<?php

namespace AtakanAtici\EDM\Classes;

use SoapClient;
use Spatie\FlareClient\Http\Response;

class Request
{
    public $hataMesaj;

    public $hataKod;

    public function send($func_name, $param)
    {
        try {
            $this->hataKod = '0';
            $this->hataMesaj = '0';
            $istemci = new SoapClient(Util::$service_url, ['trace' => 1]);
            // print_r($istemci->__getFunctions());
            // die;
            $sonuc = $istemci->__soapCall($func_name, [$param]);
            //TODO: top function is not working because of the firing exception 
            if (isset($sonuc->HataKodu)) {
                $this->hataKod = $sonuc->HataKodu;
                $this->hataMesaj = $sonuc->HataMesaji;
                throw new \Exception($sonuc->HataMesaji);
                // return $sonuc->HataMesaji;
            }
            //var_dump($istemci->__getLastRequest());
            return $sonuc;
        } catch (\SoapFault $hata) {
            $this->hataKod = $hata->faultcode;
            $this->hataMesaj = $hata->faultstring;
            // return response()->json(['hata' => $hata->faultstring], Response::HTTP_SERVER_ERROR);
            throw new \Exception($hata->faultstring);
        }
    }
}

<?php

namespace AtakanAtici\EDM\Classes;

class Request
{
    public $hataMesaj;

    public $hataKod;

    public function send($func_name, $param)
    {
        try {
            $this->hataKod = '0';
            $this->hataMesaj = '0';
            $istemci = new \SoapClient(Util::$service_url, ['trace' => 1]);
            $sonuc = $istemci->__soapCall($func_name, [$param]);
            //var_dump($istemci->__getLastRequest());
            return $sonuc;
        } catch (\SoapFault $hata) {
            $this->hataKod = $hata->faultcode;
            $this->hataMesaj = $hata->faultstring;
            throw new \Exception('Soap Hata : '.$hata->faultstring);
        }
    }
}

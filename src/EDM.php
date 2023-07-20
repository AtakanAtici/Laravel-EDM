<?php

namespace AtakanAtici\EDM;

use AtakanAtici\EDM\Classes\Fatura;
use AtakanAtici\EDM\Classes\Request;
use AtakanAtici\EDM\Classes\RequestHeader;

class EDM
{
    private $err;

    private $service_url;

    private $session_id;

    public function __construct($service_url)
    {
        $this->service_url = $service_url;
    }

    public function getErr(): array
    {
        return $this->err;
    }

    public function setErr($code, $message): void
    {
        $this->err = ['code' => $code, 'message' => $message];
    }

    //get current session id
    public function getSessionId(): mixed
    {
        return $this->session_id ?? session('EFATURA_SESSION');
    }

    //set current session id
    public function setSession($session_id): void
    {
        $this->session_id = $session_id;
        session(['EFATURA_SESSION' => $session_id]);
    }

    //login func must be called before other functions
    public function login($username, $password): bool
    {
        $header = new RequestHeader();
        $header->session_id = '-1';
        $params = $header->getArray();
        $params['USER_NAME'] = $username;
        $params['PASSWORD'] = $password;
        $request = new Request($this->service_url);
        $session = $request->send('login', $params);
        if ($session->SESSION_ID != '') {
            $this->setSession($session->SESSION_ID);

            return true;
        } else {
            $this->setErr($request->hataKod, $request->hataMesaj);

            return false;
        }
    }

    //logout func must be called after other functions
    public function logout()
    {
        $req_header = new RequestHeader();
        $req_header->session_id = $this->getSessionId();
        $param = $req_header->getArray();
        $request = new Request();
        $sonuc = $request->send('Logout', $param);
        if ($sonuc->REQUEST_RETURN->RETURN_CODE == '0') {
            return true;
        } else {
            $this->setErr($request->hataKod, $request->hataMesaj);

            return false;
        }
    }

    public function getUserList($okuma_zaman = '', $format = 'XML')
    {
        $req_header = new RequestHeader();
        $req_header->session_id = $this->getSessionId();
        $send_data = $req_header->getArray();
        if ($okuma_zaman != '') {
            $send_data['REGISTER_TIME_START'] = $okuma_zaman;
        }
        $send_data['FORMAT'] = $format;
        $req = new Request();
        $sonuc = $req->send('GetUserList', $send_data);
        $this->setErr($req->hataKod, $req->hataMesaj);

        return $sonuc->Items->Items;
    }

    public function checkUser($vkn = '', $alias = null, $unvan = null, $tip = null, $kayit_zaman = null)
    {
        if ($vkn == '') {
            return false;
        } else {
            $req_header = new RequestHeader();
            $req_header->session_id = $this->getSessionId();
            $send_data = $req_header->getArray();
            $send_data['USER']['IDENTIFIER'] = $vkn;
            if (! is_null($alias)) {
                $send_data['USER']['ALIAS'] = $alias;
            }
            if (! is_null($unvan)) {
                $send_data['USER']['TITLE'] = $unvan;
            }
            if (! is_null($tip)) {
                $send_data['USER']['TYPE'] = $tip;
            }
            if (! is_null($kayit_zaman)) {
                $send_data['USER']['REGISTER_TIME'] = $kayit_zaman;
            }
            $req = new Request();
            $sonuc = $req->send('CheckUser', $send_data);
            $this->setErr($req->hataKod, $req->hataMesaj);

            return $sonuc->USER;
        }
    }

    public function sendInvoice(Fatura $fatura)
    {

        $req_header = new RequestHeader();
        $req_header->session_id = session('EFATURA_SESSION');
        $send_data = $req_header->getArray();
        $readFatura = $fatura->readXML();
        echo $readFatura;
        $send_data["SENDER"] = array("_" => "", "alias" => $fatura->getDuzenleyen()->getGibUrn(), "vkn" => $fatura->getDuzenleyen()->getVkn());
        $send_data["RECEIVER"] = array("_" => "", "alias" => $fatura->getAlici()->getGibUrn(), "vkn" => $fatura->getAlici()->getVkn());
        $send_data["INVOICE"]["CONTENT"] = $readFatura;
        $req = new Request();
        $sonuc = $req->send("SendInvoice", $send_data);
        $this->setErr($req->hataKod, $req->hataMesaj);
        return $sonuc;
    }


}

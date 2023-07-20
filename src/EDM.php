<?php

namespace AtakanAtici\EDM;

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

    public function getSession(): string
    {
        return $this->session_id ?? session('EFATURA_SESSION');
    }

    public function setSession($session_id): void
    {
        $this->session_id = $session_id;
        session(['EFATURA_SESSION' => $session_id]);
    }

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
}

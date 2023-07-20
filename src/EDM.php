<?php

namespace AtakanAtici\EDM;

use AtakanAtici\EDM\Classes\Request;
use AtakanAtici\EDM\Classes\RequestHeader;
use phpDocumentor\Reflection\Types\Boolean;

class EDM
{
    private $err;
    private $service_url;
    private $session_id;

   public function __construct($service_url)
   {
    $this->service_url = $service_url;
   }

    function getErr() : array
    {
     return $this->err;
    }

    function setErr($code, $message) : void {
        $this->err = array("code" => $code, "message" => $message);
    }

    function getSession() : string {
        return $this->session_id ?? session("EFATURA_SESSION");
    }

    function setSession($session_id) : void {
        $this->session_id = $session_id;
        session(["EFATURA_SESSION" => $session_id]);
    }

    function login($username, $password) : bool {
        $header = new RequestHeader();
        $header->session_id = "-1";
        $params = $header->getArray();
        $param["USER_NAME"] = $username;
        $param["PASSWORD"] = $password;
        $request = new Request();
        $session = $request->send("login", $params);
        if ($session->SESSION_ID != "") {
            $this->setSession($session->SESSION_ID);
            return true;
        } else {
            $this->setErr($request->hataKod, $request->hataMesaj);
            return false;
        }
    }

}

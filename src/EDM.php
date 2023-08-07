<?php

namespace AtakanAtici\EDM;

use AtakanAtici\EDM\Classes\Fatura;
use AtakanAtici\EDM\Classes\Request;
use AtakanAtici\EDM\Classes\RequestHeader;
use AtakanAtici\EDM\Classes\Util;

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
        // echo $readFatura;
        $send_data['SENDER'] = ['_' => '', 'alias' => $fatura->getDuzenleyen()->getGibUrn(), 'vkn' => $fatura->getDuzenleyen()->getVkn()];
        $send_data['RECEIVER'] = ['_' => '', 'alias' => $fatura->getAlici()->getGibUrn(), 'vkn' => $fatura->getAlici()->getVkn()];
        $send_data['INVOICE']['CONTENT'] = $readFatura;
        $req = new Request();
        $sonuc = $req->send('SendInvoice', $send_data);
        $this->setErr($req->hataKod, $req->hataMesaj);
        return $sonuc;
    }

    public function getIncomingInvoice($limit = 10, $vkn = null, $pk = null, $baslangicTarih = null, $bitisTarih = null, $crbaslangicTarih = null, $crbitisTarih = null)
    {
        $req_header = new RequestHeader();
        $req_header->session_id = $this->getSessionId();
        $send_data = $req_header->getArray();

        $send_data["INVOICE_CONTENT_TYPE"] = "XML";
        $send_data["INVOICE_SEARCH_KEY"]["LIMIT"] = $limit;
        $send_data["INVOICE_SEARCH_KEY"]["LIMITSpecified"] = true;

        $send_data["INVOICE_SEARCH_KEY"]["DIRECTION"] = "IN";
        $send_data["INVOICE_SEARCH_KEY"]["READ_INCLUDED"] = true;
        $send_data["INVOICE_SEARCH_KEY"]["READ_INCLUDEDSpecified"] = false;

        if (!is_null($vkn)) {
            $send_data["INVOICE_SEARCH_KEY"]["RECEIVER"] = $vkn;
        }
        if (!is_null($pk)) {
            $send_data["INVOICE_SEARCH_KEY"]["TO"] = $pk;
        }
        if (!is_null($baslangicTarih)) {
            $send_data["INVOICE_SEARCH_KEY"]["START_DATE"] = $baslangicTarih;
            $send_data["INVOICE_SEARCH_KEY"]["START_DATESpecified"] = true;
        }
        if (!is_null($bitisTarih)) {
            $send_data["INVOICE_SEARCH_KEY"]["END_DATE"] = $bitisTarih;
            $send_data["INVOICE_SEARCH_KEY"]["END_DATESpecified"] = true;
        }

        if (!is_null($crbaslangicTarih)) {
            $send_data["INVOICE_SEARCH_KEY"]["CR_START_DATE"] = $crbaslangicTarih;
            $send_data["INVOICE_SEARCH_KEY"]["CR_START_DATESpecified"] = true;
        }
        if (!is_null($crbitisTarih)) {
            $send_data["INVOICE_SEARCH_KEY"]["CR_END_DATE"] = $crbitisTarih;
            $send_data["INVOICE_SEARCH_KEY"]["CR_END_DATESpecified"] = true;
        }
        $req = new Request();
        $sonuc = $req->send("GetInvoice", $send_data);
        $this->setErr($req->hataKod, $req->hataMesaj);

        $cevap = array();
        if (property_exists($sonuc, "INVOICE") && count($sonuc->INVOICE) > 0) {
            foreach ($sonuc->INVOICE as $key => $fatura) {
                $cevap[$key] = array(
                    "SENDER" => $fatura->HEADER->SENDER,
                    "RECEIVER" => $fatura->HEADER->RECEIVER,
                    "SUPPLIER" => $fatura->HEADER->SUPPLIER,
                    "CUSTOMER" => $fatura->HEADER->CUSTOMER,
                    "ISSUE_DATE" => $fatura->HEADER->ISSUE_DATE,
                    "PAYABLE_AMOUNT" => $fatura->HEADER->PAYABLE_AMOUNT->_ . " " . $fatura->HEADER->PAYABLE_AMOUNT->currencyID,
                    "FROM" => $fatura->HEADER->FROM,
                    "TO" => $fatura->HEADER->TO,
                    "PROFILEID" => $fatura->HEADER->PROFILEID,
                    "STATUS" => $fatura->HEADER->STATUS,
                    "STATUS_DESCRIPTION" => $fatura->HEADER->STATUS_DESCRIPTION,
                    "ACIKLAMA" => Util::invoiceStatus($fatura->HEADER->STATUS),
                    "GIB_STATUS_CODE" => $fatura->HEADER->GIB_STATUS_CODE,
                    "GIB_STATUS_DESCRIPTION" => $fatura->HEADER->GIB_STATUS_DESCRIPTION,
                    "RESPONSE_CODE" => $fatura->HEADER->RESPONSE_CODE,
                    "RESPONSE_DESCRIPTION" => $fatura->HEADER->RESPONSE_DESCRIPTION,
                    "FILENAME" => $fatura->HEADER->FILENAME,
                    "HASH" => $fatura->HEADER->HASH,
                    "CDATE" => new \DateTime($fatura->HEADER->CDATE),
                    "ENVELOPE_IDENTIFIER" => $fatura->HEADER->ENVELOPE_IDENTIFIER,
                    "INTERNETSALES" => $fatura->HEADER->INTERNETSALES,
                    "EARCHIVE" => $fatura->HEADER->EARCHIVE,
                    "TRXID" => $fatura->TRXID,
                    "UUID" => $fatura->UUID,
                    "ID" => $fatura->ID,
                    "TYPE" => $fatura->HEADER->INVOICE_TYPE,
                    "SENDTYPE" => $fatura->HEADER->INVOICE_SEND_TYPE
                );
            }
        }
        return $cevap;
    }

    public function getSingleInvoice($faturaNo = null, $faturaUUID = null, $gelen = false, $contentType = "XML")
    {
        if (is_null($faturaNo) && is_null($faturaUUID)) {
            return false;
        } else {
            $req_header = new RequestHeader();
            $req_header->session_id = $this->getSessionId();
            $send_data = $req_header->getArray();

            $send_data["INVOICE_CONTENT_TYPE"] = $contentType;
            $send_data["HEADER_ONLY"] = "N";
            $send_data["INVOICE_SEARCH_KEY"]["LIMIT"] = 1;
            $send_data["INVOICE_SEARCH_KEY"]["LIMITSpecified"] = true;

            $send_data["INVOICE_SEARCH_KEY"]["DIRECTION"] = ($gelen ? "IN" : "OUT");
            $send_data["INVOICE_SEARCH_KEY"]["ID"] = $faturaNo;

            $req = new Request();
            $sonuc = $req->send("GetInvoice", $send_data);
            $this->setErr($req->hataKod, $req->hataMesaj);

            return array(
                "CONTENT" => $sonuc->INVOICE->CONTENT->_,
                "SENDER" => $sonuc->INVOICE->HEADER->SENDER,
                "RECEIVER" => $sonuc->INVOICE->HEADER->RECEIVER,
                "SUPPLIER" => $sonuc->INVOICE->HEADER->SUPPLIER,
                "CUSTOMER" => $sonuc->INVOICE->HEADER->CUSTOMER,
                "ISSUE_DATE" => $sonuc->INVOICE->HEADER->ISSUE_DATE,
                "PAYABLE_AMOUNT" => $sonuc->INVOICE->HEADER->PAYABLE_AMOUNT->_ . " " . $sonuc->INVOICE->HEADER->PAYABLE_AMOUNT->currencyID,
                "PARABIRIMI" => $sonuc->INVOICE->HEADER->PAYABLE_AMOUNT->currencyID,
                "FROM" => $sonuc->INVOICE->HEADER->FROM,
                "TO" => $sonuc->INVOICE->HEADER->TO,
                "PROFILEID" => $sonuc->INVOICE->HEADER->PROFILEID,
                "STATUS" => $sonuc->INVOICE->HEADER->STATUS,
                "STATUS_DESCRIPTION" => $sonuc->INVOICE->HEADER->STATUS_DESCRIPTION,
                "ACIKLAMA" => Util::invoiceStatus($sonuc->INVOICE->HEADER->STATUS),
                "STATUS" => $sonuc->INVOICE->HEADER->STATUS,
                "GIB_STATUS_CODE" => $sonuc->INVOICE->HEADER->GIB_STATUS_CODE,
                "GIB_STATUS_DESCRIPTION" => $sonuc->INVOICE->HEADER->GIB_STATUS_DESCRIPTION,
                "RESPONSE_CODE" => $sonuc->INVOICE->HEADER->RESPONSE_CODE,
                "RESPONSE_DESCRIPTION" => $sonuc->INVOICE->HEADER->RESPONSE_DESCRIPTION,
                "FILENAME" => $sonuc->INVOICE->HEADER->FILENAME,
                "HASH" => $sonuc->INVOICE->HEADER->HASH,
                "CDATE" => $sonuc->INVOICE->HEADER->CDATE,
                "ENVELOPE_IDENTIFIER" => $sonuc->INVOICE->HEADER->ENVELOPE_IDENTIFIER,
                "INTERNETSALES" => $sonuc->INVOICE->HEADER->INTERNETSALES,
                "EARCHIVE" => $sonuc->INVOICE->HEADER->EARCHIVE,
                "TRXID" => $sonuc->INVOICE->TRXID,
                "UUID" => $sonuc->INVOICE->UUID,
                "ID" => $sonuc->INVOICE->ID,
                "TYPE" => $sonuc->INVOICE->HEADER->INVOICE_TYPE,
            );
        }
    }

    function GetInvoiceRequest($faturaNo, $contentType = "XML", $gelen = false) {
        $req_header = new RequestHeader();
        $req_header->session_id = $this->getSessionId();
        $send_data = $req_header->getArray();

        $send_data["INVOICE_CONTENT_TYPE"] = $contentType;
        $send_data["HEADER_ONLY"] = "N";
        $send_data["INVOICE_SEARCH_KEY"]["LIMIT"] = 1;
        $send_data["INVOICE_SEARCH_KEY"]["LIMITSpecified"] = true;

        $send_data["INVOICE_SEARCH_KEY"]["DIRECTION"] = ($gelen ? "IN" : "OUT");
        $send_data["INVOICE_SEARCH_KEY"]["ID"] = $faturaNo;

        $req = new Request();
        $sonuc = $req->send("GetInvoice", $send_data);
        $this->setErr($req->hataKod, $req->hataMesaj);
        return $sonuc;
    }

    function GetInvoiceStatus($faturaNo, $faturaUUID) {
        $req_header = new RequestHeader();
        $req_header->session_id = session('EFATURA_SESSION');
        $send_data = $req_header->getArray();
        $send_data["INVOICE"] = array("_" => "", "ID" => $faturaNo, "UUID" => $faturaUUID);
        $req = new Request();
        $sonuc = $req->send("GetInvoiceStatus", $send_data);
        $sonuc->INVOICE_STATUS->ACIKLAMA = Util::invoiceStatus($sonuc->INVOICE_STATUS->STATUS);
        $this->setErr($req->hataKod, $req->hataMesaj);
        return $sonuc->INVOICE_STATUS;
    }

    
}

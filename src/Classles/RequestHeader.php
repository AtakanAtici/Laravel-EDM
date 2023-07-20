<?php

namespace AtakanAtici\EDM\Classes;

class RequestHeader
{
    public $session_id;

    public $client_txn_id;

    public $int_parent_txn_id;

    public $action_date;

    public $reason = 'EFATURA UYGULAMA';

    public $application_name = 'loko';

    public $host_name = 'loko.hesapmen.com.tr';

    public $channel_name = 'HTTP';

    public $simulation_flag = 'N';

    public $compressed = 'N';

    public function getArray()
    {
        return [
            'REQUEST_HEADER' => [
                'SESSION_ID' => $this->session_id,
                'CLIENT_TXN_ID' => Util::GUID(),
                'ACTION_DATE' => Util::actionDate(),
                'REASON' => $this->reason,
                'APPLICATION_NAME' => $this->application_name,
                'HOSTNAME' => $this->host_name,
                'CHANNEL_NAME' => $this->channel_name,
                'SIMULATION_FLAG' => $this->simulation_flag,
                'COMPRESSED' => $this->compressed,
            ],
        ];
    }
}

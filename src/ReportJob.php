<?php

namespace Blazer\WorkWechatRobot;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReportJob implements ShouldQueue
{
    use Queueable;

    private $url;
    private $body;

    public function __construct($url, $body)
    {
        $this->url = $url;
        $this->body = $body;
    }

    public function handle()
    {
        $client = new Client();
        $client->post($this->url, [
            'json' => $this->body,
        ]);
    }
}
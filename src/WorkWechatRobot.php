<?php

namespace WorkWechatRobot;

use Illuminate\Support\Facades\Queue;

class WorkWechatRobot
{
    private $url;
    private $async;
    private $queue;

    public function __construct($config)
    {
        $this->url = $config['url'];
        $this->async = $config['async'];
        $this->queue = $config['queue'];
    }

    private function sendRaw($body)
    {
        $job = new ReportJob($this->url, $body);

        if ($this->async) {
            $job->onQueue($this->queue);
            Queue::push($job);
        } else {
            $job->handle();
        }
    }

    public function sendText($content, $mentionedList = [], $mentionedMobileList = [])
    {
        $body = [
            'msgtype' => 'text',
            'text' => [
                'content' => $content,
                'mentioned_list' => $mentionedList,
                'mentioned_mobile_list' => $mentionedMobileList,
            ],
        ];

        $this->sendRaw($body);
    }

    public function sendMarkDown($content)
    {
        $body = [
            'msgtype' => 'markdown',
            'markdown' => [
                'content' => $content,
            ],
        ];

        $this->sendRaw($body);
    }

    public function sendImage($content)
    {
        $body = [
            'msgtype' => 'image',
            'image' => [
                'base64' => $content,
                'md5' => md5(base64_decode($content)),
            ],
        ];

        $this->sendRaw($body);
    }
}

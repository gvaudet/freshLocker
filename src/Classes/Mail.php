<?php 

namespace App\Classes;

use Mailjet\Client;
use Mailjet\Resources;


class Mail 
{
    private $api_key = 'b8c39072daa304babf36156f858cf4b0';
    private $api_key_secret = '535591b88a2cc1b4770bc06f1d5ca1c0';

    public function send($to_email, $to_name, $subject, $content){

        $mj = new Client($this->api_key, $this->api_key_secret, true,['version' => 'v3.1']);
        $body = [
            'Messages' => [
                [
                    'From' => [
                        'Email' => "freshlockercontact@gmail.com",
                        'Name' => "FreshLocker - les Lockers du futurs"
                    ],
                    'To' => [
                        [
                            'Email' => $to_email,
                            'Name' => $to_name
                        ]
                    ],
                    'TemplateID' => 4260263,
                    'TemplateLanguage' => true,
                    'Subject' => $subject,
                    'Variables' => [
                        'content' => $content,
                    ]
                ]
            ]
        ];
        $response = $mj->post(Resources::$Email, ['body' => $body]);
        $response->success();
    }
}
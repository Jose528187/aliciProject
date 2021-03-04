<?php

namespace App\Service;

use App\Constant\GeneralConstants;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeService {

    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client){
        $this->client = $client;
    }

    private function getParams($currency)
    {
        $convertion = [];
        switch ($currency) {
            case 'USD':
                $convertion = ['base'=>'EUR', 'symbols'=>'USD'];
                break;
            default:
                $convertion = ['base'=>'USD', 'symbols'=>'EUR'];
                break;
        }
        return $convertion;
    }

    public function getExchangeCurrency($currency): float
    {
        $convertion = http_build_query($this->getParams($currency));
        $url =  GeneralConstants::URL_EXCHANGE.'?'.$convertion;
        $response = $this->client->request(
            'GET',
            GeneralConstants::URL_EXCHANGE.'?'.$convertion
        );

        $statusCode = $response->getStatusCode();
        // $statusCode = 200
        $contentType = $response->getHeaders()['content-type'][0];
        // $contentType = 'application/json'
        $content = $response->getContent();
        // $content = '{"id":521583, "name":"symfony-docs", ...}'
        $content = $response->toArray();
        // $content = ['id' => 521583, 'name' => 'symfony-docs', ...]

        return $content['rates'][$currency];
    }

}
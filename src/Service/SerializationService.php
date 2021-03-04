<?php

declare(strict_types=1);

namespace App\Service;

use App\Exception\ServiceValidationException;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Serializer\SerializerInterface;

class SerializationService
{
    private const FORMAT = 'json';
    
    private SerializerInterface $serializer;
    
    private RequestStack $requestSatck;
    
    public function __construct(SerializerInterface $serializer, RequestStack $requestSatck)
    {
        $this->serializer = $serializer;
        $this->requestSatck = $requestSatck;
    }

    public function deserializeRequestBody(string $type, $groups= []): object
    {
        $content = $this->requestSatck->getCurrentRequest()->getContent();
        
        try {
            return $this->serializer->deserialize($content, $type, 'json', ['groups'=>$groups]);
        } catch (\Exception $ex) {
            throw new ServiceValidationException($ex->getMessage());
        }
    }
}

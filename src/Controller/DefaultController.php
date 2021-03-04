<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    use ApiControllerTrait;

    /**
     * @Route("/", name="default")
     */
    public function index(): Response
    {
        $welcome = [
            'app'=> 'Acilia Test',
            'message' => 'Welcome'
        ];
        return $this->getOkResponse($welcome);
        
    }
}

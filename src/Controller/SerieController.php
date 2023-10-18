<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Entity\Actor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Serializer\SerializerInterface;



#[Route('/serie')]

class SerieController extends AbstractController{
    public function __construct( private  HttpClientInterface $tmbdClient){
    }


}

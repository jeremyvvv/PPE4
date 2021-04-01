<?php

namespace App\Controller;

use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * @Route("/web/service")
 */
class WebServiceController extends AbstractController
{
    /**
     * @Route("/", name="web_service")
     */
    public function index(): Response
    {
        return $this->render('web_service/index.html.twig', [
            'controller_name' => 'WebServiceController',
        ]);
    }

    /**
     * @Route("/apiall", name="apiall_client_show")
     */
    public function webserviceAll(): Response
    {
        $lesProduits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        $encoders = [new XmlEncoder(),new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $reponse = new Response();
        $reponse->setContent($serializer->serialize($lesProduits,'json'));
        $reponse->headers->set('Content-Type','application/json');
        return $reponse;
    }
}

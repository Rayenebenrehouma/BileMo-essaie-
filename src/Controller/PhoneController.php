<?php

namespace App\Controller;

use App\Entity\Phone;
use App\Repository\PhoneRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Env\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

class PhoneController extends AbstractController
{
    #[Route('/api/phones', name: 'phone', methods: ['GET'])]
    public function getPhoneList(PhoneRepository $phoneRepository, SerializerInterface $serializer): JsonResponse
    {
        $phoneList = $phoneRepository->findAll();
        $jsonPhoneList = $serializer->serialize($phoneList, 'json');
        //dd($phoneList);

        return new JsonResponse($jsonPhoneList, Response::HTTP_OK, [], true);
    }

    //Détails des téléphone
    #[Route('/api/phones/{id}', name: 'phoneDetails', methods: ['GET'])]
    public function getPhoneDetails(SerializerInterface $serializer, Phone $phone)
    {
            $jsonPhone = $serializer->serialize($phone, 'json');
            return new JsonResponse($jsonPhone, Response::HTTP_OK, [], true);
    }


    #[Route('/api/phones/{id}', name: 'deletePhone', methods: ['DELETE'])]
    public function deletePhone(Phone $phone, EntityManagerInterface $em): JsonResponse
    {

        $em->remove($phone);
        $em->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }

    public function createPhone(Request $request,SerializerInterface $serializer,EntityManagerInterface $em, UrlGeneratorInterface $urlGenerator): JsonResponse
    {

    }
}

<?php

namespace App\Controller;

use App\Entity\Travel;
use App\Service\TravelService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/v1/travel')]

class TravelController extends  AbstractController
{

    public function __construct(
        protected ManagerRegistry       $managerRegistry,
        protected SerializerInterface   $serializer,
        protected ValidatorInterface    $validator,
        protected DenormalizerInterface $denormalizer,
    ) {
    }
    #[Route('/calculate', methods: ['POST'])]
    public function createDriverItemAction(Request $request, TravelService $travelService): Response
    {
        try {
            /** @var Travel $item */
            $entity = $this->serializer->deserialize(
                $request->getContent(),
                Travel::class,
                'json'
            );
            $entity = $travelService->calculate($entity);

            return $this->json(
                $entity,
                Response::HTTP_OK,
                [],
            );
        } catch (\Exception $exception) {
            return $this->json(['error' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

}

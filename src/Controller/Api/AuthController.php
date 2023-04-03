<?php

namespace App\Controller\Api;

use App\Entity\Customer;
use App\Entity\Parcours;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/auth", name="auth.")
 */
class AuthController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/login", name="login", methods={"POST"})
     */
    public function login(Request $request): JsonResponse
    {   
        $data = json_decode($request->getContent(), true);
        $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['name' => $data['name']]);

        if (!$customer) {
        return new JsonResponse(['status' => 'error', 'message' => 'Invalid credentials'], 401);
        }

        return new JsonResponse(['status' => 'success', 'message' => 'Logged in successfully']);
    }
    /**
     * @Route("/password", name="password", methods={"POST"})
     */
    public function setPassword(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['name' => $data['name']]);
        
        if (!$customer) {
            return new JsonResponse(['status' => 'error', 'message' => 'Customer not found'], 404);
        }

        $customer->setPassword($data['password']);
        $this->entityManager->flush();

        return new JsonResponse(['status' => 'success', 'message' => 'Password saved']);
    }
    /**
     * @Route("/parcours/{name}", name="parcours", methods={"GET"})
     */
    public function getParcoursByCustomerName($name): JsonResponse
    {
        $customer = $this->entityManager->getRepository(Customer::class)->findOneBy(['name' => $name]);

        if (!$customer) {
            return new JsonResponse(['status' => 'error', 'message' => 'Customer not found'], 404);
        }

        $parcours = $customer->getParcours();

        if (!$parcours) {
            return new JsonResponse(['status' => 'error', 'message' => 'Parcours not found'], 404);
        }

        return new JsonResponse([
            'status' => 'success',
            'origin' => $parcours->getOrigin(),
            'destination' => $parcours->getDestination(),
        ]);
    }
    
}


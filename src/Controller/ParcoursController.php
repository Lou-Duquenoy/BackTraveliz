<?php

namespace App\Controller;

use App\Entity\Parcours;
use App\Form\ParcoursType;
use App\Repository\ParcoursRepository;
use App\Repository\CustomerRepository;
use App\Service\HelperService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ContentDisposition;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Snappy\Pdf;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Label\Font\NotoSans;


#[Route('/parcours')]
class ParcoursController extends AbstractController
{
    private ParcoursRepository $parcoursRepository;

    private EntityManagerInterface $em;
    private HelperService $helperService;
    public function __construct(ParcoursRepository $parcoursRepository, EntityManagerInterface $em, HelperService $helperService, CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->parcoursRepository = $parcoursRepository;
        $this->em = $em;
        $this->helperService = $helperService;
    }

    #[Route('/', name: 'app_parcours_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('parcours/index.html.twig', [
            'parcours' => $this->parcoursRepository->findAll(),
        ]);
    }
    #[Route('/new/{customerId}', name: 'app_parcours_new', methods: ['GET', 'POST'])]
    public function new(Request $request, int $customerId, ParcoursRepository $parcoursRepository, CustomerRepository $customerRepository): Response
    {
        $parcours = new Parcours();
        $form = $this->createForm(ParcoursType::class, $parcours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Use the Geocoding API to get the coordinates for the destination
            $destination = $parcours->getDestination();
            $apiKey = 'AIzaSyAwPxt4Oi9wvbubOMcVmxpJY6DoNPMbvpo'; // Replace with your Google Cloud API key
            $client = HttpClient::create();
            $response = $client->request('GET', "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($destination)."&key=$apiKey");
            $data = $response->toArray();
            
            if (isset($data['results'][0]['geometry']['location'])) {
                $coordinates = $data['results'][0]['geometry']['location'];
                $latitude = $coordinates['lat'];
                $longitude = $coordinates['lng'];
                $parcours->setLatitude($latitude);
                $parcours->setLongitude($longitude);
            } else {
                $this->addFlash('error', 'Failed to get coordinates for destination');
            }

            $customer = $customerRepository->find($customerId);
            if (!$customer) {
                throw $this->createNotFoundException('The customer does not exist');
            }

            $parcours->setCustomer($customer);
            $this->em->persist($parcours);
            $this->em->flush();

            $customer->setParcours($parcours);
            $this->em->flush();
            $this->addFlash('add', 'Le parcours a été créé');

            return $this->redirectToRoute('app_customer_show', ['id' => $customerId]);
        }

        return $this->renderForm('parcours/index.html.twig', [
            'parcours' => $parcours,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parcours_show', methods: ['GET'])]
    public function show(Parcours $parcours): Response
    {
        return $this->render('parcours/show.html.twig', [
            'parcours' => $parcours,
        ]);
    }
    #[Route('/{id}/edit', name: 'app_parcours_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parcours $parcours): Response
    {
        $form = $this->createForm(ParcoursType::class, $parcours);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->parcoursRepository->save($parcours, true);
            
            return $this->redirectToRoute('app_parcours_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('parcours/edit.html.twig', [
            'parcours' => $parcours,
            'form' => $form,
        ]);
    }
    
}
<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/", name="client")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted()&& $form->isValid()){

            $data = $form->getData();

            $em->persist($client);
            $em->flush();

            return $this->redirectToRoute("client");
        }

        $clients = $em->getRepository(Client::class)->findAll();

        return $this->render('client/index.html.twig', [
            'title' => 'Клиенты',
            'form' => $form->createView(),
            'clients' => $clients
        ]);
    }

    /**
     * @Route("/client/single/{client}", name="client_single")
     */
    public function single(Client $client) {

        $cars = $client->getCars();

        return $this->render('client/single.html.twig', [
            'title' => 'Клиент ',
            'client' => $client,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/client/remove/{client}", name="client_remove")
     */
    public function clientRemove(Client $client, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($client);
        $em->flush();

        return $this->redirectToRoute("client");
    }
}

<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Client;
use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    /**
     * @Route("/car", name="car")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository(Car::class)->findAll();
        $clients = $em->getRepository(Client::class)->findAll();

        return $this->render('car/index.html.twig', [
            'title' => 'Машины',
            'clients' => $clients,
            'cars' => $cars
        ]);
    }

    /**
     * @Route("/car/add", name="car_add", methods="POST")
     */

    public function carAdd(Request $request, ClientRepository $clietnRepository)
    {
        $mark = $request->get('mark');
        $model = $request->get('model');
        $number = $request->get('number');
        $vin = $request->get('vin');
        $client_id = $request->get('client_id');
        $client = $clietnRepository->find($client_id);

        $car = new Car();

        $car->setMark($mark);
        $car->setModel($model);
        $car->setNumber($number);
        $car->setVin($vin);
        $car->setClient($client);

        $em = $this->getDoctrine()->getManager();
        $em->persist($car);
        $em->flush();

        return $this->redirectToRoute('car');

    }

    /**
     * @Route("/car/single/{car}", name="car_single")
     */
    public function single(Car $car) {

        $services = $car->getServices();

        return $this->render('car/single.html.twig', [
            'title' => 'Машина ',
            'car' => $car,
            'services' => $services
        ]);
    }

    /**
     * @Route("/car/remove/{car}", name="car_remove")
     */
    public function carRemove(Car $car, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($car);
        $em->flush();

        return $this->redirectToRoute("car");
    }
}

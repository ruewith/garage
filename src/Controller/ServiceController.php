<?php

namespace App\Controller;

use App\Entity\Car;
use App\Entity\Service;
use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    /**
     * @Route("/service", name="service")
     */
    public function index(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cars = $em->getRepository(Car::class)->findAll();
        $services = $em->getRepository(Service::class)->findAll();

        return $this->render('service/index.html.twig', [
            'title' => 'Работы',
            'cars' => $cars,
            'services' => $services
        ]);
    }

    /**
     * @Route("/service/add", name="service_add", methods="POST")
     */

    public function carAdd(Request $request, CarRepository $carRepository)
    {

        $mileage = $request->get('mileage');
        $oil= $request->get('oil');
        $descr = $request->get('description');
        $date = $request->get('date');
        $service_date = \DateTime::createFromFormat('Y-m-d', $date);
        $car_id = $request->get('car_id');
        $car = $carRepository->find($car_id);

        $service = new Service();

        $service->setMileage($mileage);
        $service->setOil($oil);
        $service->setDescription($descr);
        $service->setCreatedAt($service_date);
        $service->setCar($car);

        $em = $this->getDoctrine()->getManager();
        $em->persist($service);
        $em->flush();

        return $this->redirectToRoute('service');

    }

    /**
     * @Route("/service/single/{service}", name="service_single")
     */
    public function single(Service $service) {
        return $this->render('service/single.html.twig', [
            'title' => 'Работа от',
            'service' => $service
        ]);
    }

    /**
     * @Route("/service/remove/{service}", name="service_remove")
     */
    public function carRemove(Service $service, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($service);
        $em->flush();

        return $this->redirectToRoute("service");
    }
}

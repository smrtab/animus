<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Apartment;

class ApiController extends FOSRestController
{

    /**
     * @Rest\Get("api/apartments")
     */
    public function getAction()
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Apartment')->findAll();
        if (null === $result) {
            return new View("there are no apartments exist", Response::HTTP_NOT_FOUND);
        }
        return $result;
    }

    /**
     * @Rest\Get("api/apartments/{id}")
     */
    public function getApartmentAction($id)
    {
        $result = $this->getDoctrine()->getRepository('AppBundle:Apartment')->find($id);
        if (null === $result) {
            return [];
        }
        return $result;
    }

    /**
     * @Rest\Post("api/apartment/add")
     */
    public function setApartmentAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $apartment = new Apartment();
        $apartment->setMoveInDate(new \DateTime($request->get('move_in_date')));
        $apartment->setStreet($request->get('street'));
        $apartment->setPostCode($request->get('post_code'));
        $apartment->setTown($request->get('town'));
        $apartment->setCountry($request->get('country'));
        $apartment->setEmail($request->get('email'));

        $em->persist($apartment);
        $em->flush();

        if (!$apartment->getId()) {
            return new View("there are no apartments exist", Response::HTTP_NOT_FOUND);
        }

        return $apartment;
    }
}

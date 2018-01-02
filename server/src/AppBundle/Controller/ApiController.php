<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Apartment;
use AppBundle\Controller\TokenAuthenticatedController;

class ApiController extends FOSRestController implements TokenAuthenticatedController
{

    /**
     * @Rest\Get("api/apartments")
     */
    public function getAction()
    {
    	try {
		    $result = $this->getDoctrine()->getRepository('AppBundle:Apartment')->findAll();

		    if (!$result) {
			    return new View([], Response::HTTP_OK);
		    }

		    return $result;
	    } catch(\Exception $e) {
		    $this->get("logger")->critical("Got exception ".$e->getMessage());
		    return new View([
			    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
			    'message'=>$e->getMessage()
		    ], Response::HTTP_INTERNAL_SERVER_ERROR);
	    }

    }

    /**
     * @var integer $id
     * @Rest\Get("api/apartments/{id}")
     * @return Apartment $result
     */
    public function getApartmentAction($id)
    {
    	try {
		    $result = $this->getDoctrine()->getRepository('AppBundle:Apartment')->find($id);
		    if (null === $result) {
			    throw $this->createAccessDeniedException("Acess denied", Response::HTTP_INTERNAL_SERVER_ERROR);
		    }
		    return $result;
	    } catch (\Exception $e) {
		    $this->get("logger")->critical("Got exception ".$e->getMessage());
		    return new View([
			    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
			    'message'=>$e->getMessage()
		    ], Response::HTTP_INTERNAL_SERVER_ERROR);
	    }
    }

    /**
     * @var Request $request
     * @Rest\Post("api/apartment/add")
     * @return Apartment $apartment
     */
    public function setApartmentAction(Request $request)
    {
        try {

            $manager = $this->getDoctrine()->getManager();

            $apartment = new Apartment();
	        $apartment->setMoveInDate(new \DateTime($request->get('move_in_date')));
	        $apartment->setStreet($request->get('street'));
	        $apartment->setPostCode($request->get('post_code'));
	        $apartment->setTown($request->get('town'));
	        $apartment->setCountry($request->get('country'));
	        $apartment->setEmail($request->get('email'));

	        $manager->persist($apartment);
	        $manager->flush();

            if (!$apartment->getId()) {
                throw $this->createNotFoundException("Unexpected behavior while saving", Response::HTTP_INTERNAL_SERVER_ERROR);
            }

	        $body = $this->renderView(
		        'Emails/notification.html.twig',
		        array('id' => $apartment->getId())
	        );

	        $headers = [
		        'From: Animus <no_reply@animus.com>'
		    ];

	        mail($request->get('email'), 'New appartment added', $body, implode("\r\n", $headers));

            return $apartment;

        } catch(\Exception $e) {
	        $this->get("logger")->critical("Got exception ".$e->getMessage());
	        return new View([
	        	'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
		        'message'=>$e->getMessage()
	        ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

	/**
	 * @var Request $request
	 * @Rest\Put("api/apartment/update")
	 * @return Apartment $apartment*
	 */
	public function updateApartmentAction(Request $request)
	{
		try {

			$id = $request->get('id');

			$manager = $this->getDoctrine()->getManager();
			$apartment = $manager->getRepository('AppBundle:Apartment')->find($id);

			if (!$apartment) {
				throw $this->createAccessDeniedException("Acess denied", Response::HTTP_INTERNAL_SERVER_ERROR);
			}

			$apartment->setMoveInDate(new \DateTime($request->get('move_in_date')));
			$apartment->setStreet($request->get('street'));
			$apartment->setPostCode($request->get('post_code'));
			$apartment->setTown($request->get('town'));
			$apartment->setCountry($request->get('country'));
			$apartment->setEmail($request->get('email'));

			$manager->flush();

			if (!$apartment->getId()) {
				return new View("there are no apartments exist", Response::HTTP_NOT_FOUND);
			}

			return $apartment;

		} catch(\Exception $e) {
			$this->get("logger")->critical("Got exception ".$e->getMessage());
			return new View([
				'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
				'message'=>$e->getMessage()
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}

	}

    /**
     * @var integer $id
     * @Rest\Delete("api/apartment/delete/{id}")
     * @return boolean
     */
    public function deleteApartmentAction($id)
    {
        try {

            $manager = $this->getDoctrine()->getManager();

	        $apartment = $manager->getRepository('AppBundle:Apartment')->find($id);

	        $manager->remove($apartment);
	        $manager->flush();

            return true;

        } catch(\Exception $e) {
	        $this->get("logger")->critical("Got exception ".$e->getMessage());
	        return new View([
		        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
		        'message'=>$e->getMessage()
	        ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

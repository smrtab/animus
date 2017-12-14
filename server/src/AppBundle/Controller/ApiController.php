<?php

namespace AppBundle\Controller;

use Mockery\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\Debug\Exception\FatalErrorException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Apartment;
use AppBundle\Entity\ApartmentToken;
use Monolog\Logger;

class ApiController extends FOSRestController
{

	private $logger;

	public function __construct(){
		$this->logger = new Logger("api");
	}

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
		    $this->logger->critical("Got exception ".$e->getMessage());
		    return new View([
			    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
			    'message'=>$e->getMessage()
		    ], Response::HTTP_INTERNAL_SERVER_ERROR);
	    }

    }

    /**
     * @Rest\Get("api/apartments/{id}")
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
		    $this->logger->critical("Got exception ".$e->getMessage());
		    return new View([
			    'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
			    'message'=>$e->getMessage()
		    ], Response::HTTP_INTERNAL_SERVER_ERROR);
	    }
    }

    /**
     * @Rest\Post("api/apartment/add")
     */
    public function setApartmentAction(Request $request)
    {
        try {

            if (null == $request->get('move_in_date'))
                throw new \Exception("move_in_date must be present", 500);

            if (null == $request->get('street'))
                throw new \Exception("street must be present", 500);

            if (null == $request->get('post_code'))
                throw new \Exception("post_code must be present", 500);

            if (null == $request->get('town'))
                throw new \Exception("town must be present", 500);

            if (null == $request->get('country'))
                throw new \Exception("country must be present", 500);

            if (null == $request->get('email'))
                throw new \Exception("email must be present", 500);

            $manager = $this->getDoctrine()->getManager();

            $apartment = new Apartment();
            $result = $apartment->create([
                'move_in_date'  => new \DateTime($request->get('move_in_date')),
                'street'        => $request->get('street'),
                'post_code'     => $request->get('post_code'),
                'town'          => $request->get('town'),
                'country'       => $request->get('country'),
                'email'         => $request->get('email')
            ], $manager);

            if (!$result->getId()) {
                throw $this->createNotFoundException("Unexpected behavior while saving", Response::HTTP_INTERNAL_SERVER_ERROR);
            }

	        $atoken = new ApartmentToken();
	        $atoken->createFor($result->getId(), $manager);

	        $body = $this->renderView(
		        'Emails/notification.html.twig',
		        array('id' => $result->getId())
	        );

	        $headers = [
		        'From: Animus <no_reply@animus.com>',
	            'Cc: birthdayarchive@example.com',
		        'X-Mailer: PHP/' . phpversion()
		    ];

	        mail($request->get('email'), 'New appartment added', $body, implode("\r\n", $headers));

            return $apartment;

        } catch(\Exception $e) {
	        $this->logger->critical("Got exception ".$e->getMessage());
	        return new View([
	        	'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
		        'message'=>$e->getMessage()
	        ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

	/**
	 * @Rest\Put("api/apartment/update")
	 */
	public function updateApartmentAction(Request $request)
	{
		try {

			if (null == $request->get('id'))
				throw new \Exception("id must be present", 500);

			if (null == $request->get('move_in_date'))
				throw new \Exception("move_in_date must be present", 500);

			if (null == $request->get('street'))
				throw new \Exception("street must be present", 500);

			if (null == $request->get('post_code'))
				throw new \Exception("post_code must be present", 500);

			if (null == $request->get('town'))
				throw new \Exception("town must be present", 500);

			if (null == $request->get('country'))
				throw new \Exception("country must be present", 500);

			if (null == $request->get('email'))
				throw new \Exception("email must be present", 500);

			$id = $request->get('id');

			$manager = $this->getDoctrine()->getManager();
			$apartment = $manager->getRepository('AppBundle:Apartment')->find($id);

			if (!$apartment) {
				throw $this->createAccessDeniedException("Acess denied", Response::HTTP_INTERNAL_SERVER_ERROR);
			}

			$result = $apartment->update([
				'move_in_date'  => new \DateTime($request->get('move_in_date')),
				'street'        => $request->get('street'),
				'post_code'     => $request->get('post_code'),
				'town'          => $request->get('town'),
				'country'       => $request->get('country'),
				'email'         => $request->get('email')
			], $manager);

			if (!$result->getId()) {
				return new View("there are no apartments exist", Response::HTTP_NOT_FOUND);
			}

			return $apartment;

		} catch(\Exception $e) {
			$this->logger->critical("Got exception ".$e->getMessage());
			return new View([
				'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
				'message'=>$e->getMessage()
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}

	}

    /**
     * @Rest\Delete("api/apartment/delete/{id}")
     */
    public function deleteApartmentAction($id)
    {
        try {

            $manager = $this->getDoctrine()->getManager();

            $apartment = new Apartment();
            $apartment->delete($id, $manager);

            return true;

        } catch(\Exception $e) {
	        $this->logger->critical("Got exception ".$e->getMessage());
	        return new View([
		        'status'=>Response::HTTP_INTERNAL_SERVER_ERROR,
		        'message'=>$e->getMessage()
	        ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

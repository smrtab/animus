<?php

namespace AppBundle\Controller;

use Mockery\Exception;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\Apartment;
use AppBundle\Entity\ApartmentToken;
use Psr\Log\LoggerInterface;

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
                return new View("there are no apartments exist", Response::HTTP_NOT_FOUND);
            }

	        $atoken = new ApartmentToken();
	        $atoken->createFor($result->getId(), $manager);

            $message = \Swift_Message::newInstance()
                ->setSubject('Hello Email')
                ->setFrom('send@example.com')
                ->setTo($request->get('email'))
                ->setBody(
                    $this->renderView(
                    // app/Resources/views/Emails/registration.html.twig
                        'Emails/notification.html.twig',
                        array('id' => $result->getId())
                    ),
                    'text/html'
                )
            ;
            $this->get('mailer')->send($message);

            return $apartment;

        } catch(\Exception $e) {

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
				throw $this->createNotFoundException(
					'No apartment found for id '.$id
				);
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

        }

    }
}

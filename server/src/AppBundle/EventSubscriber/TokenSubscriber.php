<?php

namespace AppBundle\EventSubscriber;

use AppBundle\Controller\TokenAuthenticatedController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
	private $tokens;

	public function __construct($tokens){
		$this->tokens = $tokens;
	}

	public function onKernelController(FilterControllerEvent $event)
	{
		$controller = $event->getController();

		/*
		 * $controller passed can be either a class or a Closure.
		 * This is not usual in Symfony but it may happen.
		 * If it is a class, it comes in array format
		 */
		if (!is_array($controller)) {
			return;
		}

		if ($controller[0] instanceof TokenAuthenticatedController) {
			$token = $event->getRequest()->headers->get('AuthToken');
			if (!in_array($token, $this->tokens)) {
				throw new AccessDeniedHttpException('This action needs a valid token!');
			}
		}
	}

	public static function getSubscribedEvents()
	{
		return array(
			KernelEvents::CONTROLLER => 'onKernelController',
		);
	}
}
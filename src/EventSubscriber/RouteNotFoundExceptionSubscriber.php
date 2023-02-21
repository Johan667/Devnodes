<?php

namespace App\EventSubscriber;

use App\Exception\RouteNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

class RouteNotFoundExceptionSubscriber implements EventSubscriberInterface
{
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();
        if ($exception instanceof RouteNotFoundException) {
            $response = new Response($this->twig->render('errors/error500.html.twig'), Response::HTTP_NOT_FOUND);
            $event->setResponse($response);
        } else {
            // Handle all other unhandled exceptions
            $response = new Response($this->twig->render('errors/error500.html.twig'), Response::HTTP_INTERNAL_SERVER_ERROR);
            $event->setResponse($response);
        }
    }


    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }

}
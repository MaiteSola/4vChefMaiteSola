<?php

namespace App\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Serializer\Exception\MissingConstructorArgumentsException;

#[AsEventListener(event: KernelEvents::EXCEPTION)]
class ValidationExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        // CASO 1: Fallo de validación de Symfony (Asserts en el DTO)
        if ($exception instanceof HttpExceptionInterface) {
            $previous = $exception->getPrevious();
            
            if ($previous instanceof ValidationFailedException) {
                // Cogemos la primera violación para mostrar un mensaje limpio
                $violation = $previous->getViolations()->get(0);
                
                // Formato estricto del YAML
                $data = [
                    'code' => 400, 
                    'description' => $violation->getMessage() 
                ];

                $event->setResponse(new JsonResponse($data, 400));
                return;
            }
        }

        // CASO 2: JSON mal formado o campos faltantes (si el Serializer se queja)
        if ($exception instanceof MissingConstructorArgumentsException) {
             $data = [
                'code' => 400,
                'description' => 'Faltan campos obligatorios en el JSON: ' . implode(', ', $exception->getMissingConstructorArguments())
            ];
            $event->setResponse(new JsonResponse($data, 400));
        }
    }
}
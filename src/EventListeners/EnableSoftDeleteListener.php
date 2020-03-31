<?php
namespace Souto\SoftDeleteBundle\EventListeners;

use Doctrine\ORM\EntityManagerInterface;
use Souto\SoftDeleteBundle\Exceptions\DisabledRouteFound;
use Symfony\Component\HttpKernel\Event\RequestEvent;

final class EnableSoftDeleteListener
{
    private $entityManager;

    private $routesDisabled;

    public function __construct(EntityManagerInterface $entityManager, array $routesDisabled)
    {
        $this->entityManager = $entityManager;
        $this->routesDisabled = $routesDisabled;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $isValid = $this->checkValidPrefix(
            $event->getRequest()->getRequestUri()
        );

        if (! $isValid) {
            return;
        }

        $this->entityManager
            ->getFilters()
            ->enable('soft_delete_filter')
            ->setParameter('withThrashed', 'disabled')
            ->setParameter('dateNow', date("Y-m-d h:m:s"));
    }

    private function checkValidPrefix(string $uri): bool
    {
        $routeUris = explode('/', $uri);

        $filteredUris = array_filter($routeUris);

        if ($filteredUris == null) {
            return true;
        }

        foreach ($filteredUris as $index => $uri) {

            if (is_int($uri)) {
                continue;
            }

            if (in_array($uri, $this->routesDisabled)) {
                return false;
            }

            return true;
        }

    }

}
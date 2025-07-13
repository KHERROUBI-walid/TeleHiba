<?php

namespace App\EventListener;

use App\Entity\User;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Bundle\SecurityBundle\Security;

class CompleteProfileListener
{
    public function __construct(
        private Security $security,
        private RouterInterface $router,
        private RequestStack $requestStack
    ) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $route = $request->attributes->get('_route');

        // Ne pas exécuter sur les requêtes AJAX, assets, admin, erreurs, ou routes spécifiques
        if (
            $request->isXmlHttpRequest() ||
            str_starts_with($request->getPathInfo(), '/_') ||
            str_starts_with($request->getPathInfo(), '/admin') ||
            str_starts_with($request->getPathInfo(), '/_error') ||
            in_array($route, ['app_logout', 'app_register_famille', 'app_register_vendeur', 'app_accueil', 'app_verify_email'])
        ) {
            return;
        }

        /** @var User|null $user */
        $user = $this->security->getUser();
        if (!$user) {
            return;
        }

        // S'il est donateur → il n'a rien à compléter
        if ($user->getDonateur()) {
            return;
        }

        // Si Vendeur n’est pas complété
        if (in_array('ROLE_VENDEUR', $user->getRoles(), true) && !$user->getVendeur()) {
            $response = new RedirectResponse($this->router->generate('app_register_vendeur'));
            $event->setResponse($response);
            return;
        }

        // Si Famille n’est pas complétée
        if (in_array('ROLE_FAMILLE', $user->getRoles(), true) && !$user->getFamille()) {
            $response = new RedirectResponse($this->router->generate('app_register_famille'));
            $event->setResponse($response);
            return;
        }
    }
}

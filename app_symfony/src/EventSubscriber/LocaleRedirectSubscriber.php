<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class LocaleRedirectSubscriber implements EventSubscriberInterface
{
    private array $locales = ['fr', 'en', 'ar'];
    private string $defaultLocale = 'fr';
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        // Si la route n'est pas "/" on ne fait rien
        if ($request->getPathInfo() !== '/') {
            return;
        }

        // On détecte la langue préférée du navigateur
        $preferredLang = $request->getPreferredLanguage($this->locales) ?? $this->defaultLocale;

        // Redirection vers la locale détectée
        $event->setResponse(new RedirectResponse('/' . $preferredLang));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 100]],
        ];
    }
}

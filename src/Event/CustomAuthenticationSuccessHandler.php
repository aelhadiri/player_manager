<?php

namespace App\Event;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Event\AuthenticationSuccessEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;


class CustomAuthenticationSuccessHandler {
    private $router;
    private $accessDecisionManager;

    public function __construct(AccessDecisionManagerInterface $accessDecisionManager, Router $router)
    {
        $this->accessDecisionManager = $accessDecisionManager;
        $this->router = $router;
    }

    public function onSecurityInteractiveLogin(AuthenticationSuccessEvent $event): void
    {
        dd($event);
        $this->onAuthenticationSuccess($event->getAuthenticationToken());
    }

//    public function isGranted(UserInterface $user, $attribute, $object = null) {
        // $token = new UsernamePasswordToken($user, 'none', 'none', $user->getRoles());
    public function isGranted(PostAuthenticationToken $token, $attribute, $object = null) {
        return ($this->accessDecisionManager->decide($token, [$attribute], $object));
    }

    public function onAuthenticationSuccess( AuthenticationSuccessEvent $event): RedirectResponse
    {
        $token =$event->getAuthenticationToken();
//        dd($this->isGranted($token, 'ROLE_ADMIN'));
//        dump($this->accessDecisionManager->decide($token, ['ROLE_ADMIN']));
//        dd($event->getAuthenticationToken());
        if ( $this->isGranted($token, 'ROLE_ADMIN')) {
            //dd($this->router->generate('admin_homepage'));
            return new RedirectResponse($this->router->generate('admin_homepage'));
        }
        dd("xx");
        return new RedirectResponse($this->router->generate('app_homepage'));
    }
}
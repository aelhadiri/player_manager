<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function home(): Response
    {
        if ( $this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('admin_homepage');
        }
        return $this->redirectToRoute('app_club_list');
    }
}

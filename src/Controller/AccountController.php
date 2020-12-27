<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class AccountController extends AbstractController
{
    /**
     * @Route("/my_profile", name="app_profile")
     * @IsGranted("ROLE_CONTRIBUTOR")
     */
    public function index(): Response
    {
        return $this->render('account/profile.html.twig');
    }
}

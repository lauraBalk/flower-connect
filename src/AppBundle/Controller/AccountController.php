<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
/**
* @Route("/account")
*/
class AccountController extends Controller
{
    /**
    * @Route("/")
    */
    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // replace this example code with whatever you need
        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
    * @Route("/new-pot")
    */
    public function newPotAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // replace this example code with whatever you need
        return $this->render('account/new-pot.html.twig', [
            'user' => $user,
        ]);
    }
}

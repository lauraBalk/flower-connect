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

    /**
     * Route("/search-code")
     */
    public function searchCodeAction(Request $request)
    {
        $data = $request->request->get('data');
        if ($data)
        {
            //search 
            $pot = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('AppBundle:Pot')
                    ->findBy(array('code' => $data));
            if ($pot && !$pot->getName())
            {
                //render form pot
            }
            else 
            {
                // return error for false code or pot already registered
            }  
        }
    }
}

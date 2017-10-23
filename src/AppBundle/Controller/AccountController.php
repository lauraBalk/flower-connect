<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Pot;
use AppBundle\Form\PotType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     *@Route("/search-code")
     */
    public function searchCodeAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        //This is optional. Do not do this check if you want to call the same action using a regular request.
        $data = $request->request->get('data');
        if ($data)
        {
            //search 
            $em = $this->getDoctrine()->getManager();
            $pot = $em->getRepository('AppBundle:Pot')
                    ->findOneByCode($data);
            if ($pot && $pot->getUser() == null)
            {
                $pot->setUser($user);
                $em->flush();
                $form = $this->editPotForm($pot);
                return $this->render('account/search-code.html.twig', array(
                    'form' => $form->createView(),
                    'pot' => $pot,
                ));
            }
            else 
            {
                 return new JsonResponse(array('message' => 'error!'), 400);
            }  
        }
        else
        {
            return new JsonResponse(array('message' => 'error!'), 400);
        }
    }
    /**
     *@Route("/{id}/edit-pot")
     */
    public function editPotAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();
        $pot = $em->getRepository('AppBundle:Pot')
                    ->find($id);
         $form = $this->editPotForm($pot);
         $form->handleRequest($request);
        if ($form->isValid())
        {
            $em -> persist($pot);
            $em -> flush();
            $request->getSession()->getFlashBag()->add('notice', 'Pot bien modifiée.');
            return $this->redirect($this->generateUrl('app_account_index'));
        }
        return $this->render('account/edit-pot.html.twig', array(
            'form' => $form->createView(),
            'pot' => $pot,
        ));
    }

    /**
     *@Route("/{id}/stat-pot")
     */
    public function statPotAction(Request $request, $id)
    {
         $em = $this->getDoctrine()->getManager();
        $pot = $em->getRepository('AppBundle:Pot')
                    ->find($id);
        return $this->render('account/stat-pot.html.twig', array(
            'pot' => $pot,
        ));
    }

    private function editPotForm(Pot $pot)
    {
        $form = $this->createForm(PotType::class, $pot,
                array(
            'action' => $this->generateUrl('app_account_editpot',array('id' => $pot->getId())),
            'method' => 'POST',
        ));
     
        return $form;
    }

    /**
     * @Route("/photoPot")
     */
    public function photoPotAction(Request $request)
    {
        return $this->render('account/photo-pot.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}

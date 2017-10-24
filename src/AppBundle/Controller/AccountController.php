<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\ColumnChart;
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
        return $this->render('account/edit.html.twig', array(
            'form' => $form->createView(),
            'pot' => $pot,
        ));
    }

    /**
     *@Route("/{id}/state-pot")
     */
    public function statPotAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $pot = $em->getRepository('AppBundle:Pot')
                    ->find($id);

        $avgMoisture = $this->getDoctrine()
            ->getRepository('AppBundle:Pot')
            ->getAvgMoistureByDay($id);

        $moistureChart = new ColumnChart();
        $dataMoistureChart = array();

        $dataMoistureChart[0] = ['1', 'Moisture'];
        for ($i=1; $i <= date("t", strtotime("last day of this month")) ; $i++) {
            $array_search = array_search($i,  array_column($avgMoisture, 'day'));
            
            if (is_bool($array_search) === false)
            {
                 $dataMoistureChart[$i] = [$i, $avgMoisture[$array_search]['avg_moisture']];
            }
            else
            {
                 $dataMoistureChart[$i] = [$i, 0];
            }
           
        }
        $moistureChart->getData()->setArrayToDataTable($dataMoistureChart);
        $moistureChart->getOptions()->getLegend()->setPosition('top');
        $moistureChart->getOptions()->setWidth(850);
        $moistureChart->getOptions()->setHeight(450);

        $avgTemperature = $this->getDoctrine()
            ->getRepository('AppBundle:Pot')
            ->getAvgTemperatureByDay($id);

        $temperatureChart = new ColumnChart();
        $dataTemperatureChart = array();

        $dataTemperatureChart[0] = ['1', 'temprature'];
        for ($i=1; $i <= date("t", strtotime("last day of this month")) ; $i++) {
            $array_search = array_search($i,  array_column($avgTemperature, 'day'));
            
            if (is_bool($array_search) === false)
            {
                 $dataTemperatureChart[$i] = [$i, $avgTemperature[$array_search]['avg_temperature']];
            }
            else
            {
                 $dataTemperatureChart[$i] = [$i, 0];
            }
           
        }
        $temperatureChart->getData()->setArrayToDataTable($dataTemperatureChart);
        $temperatureChart->getOptions()->getLegend()->setPosition('top');
        $temperatureChart->getOptions()->setWidth(850);
        $temperatureChart->getOptions()->setHeight(450);
            return $this->render('account/stat-pot.html.twig', array(
                'moistureChart' => $moistureChart,
                'temperatureChart' => $temperatureChart,
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
     * @Route("/photoPot", name="photoPot")
     */
    public function photoPotAction(Request $request)
    {
        return $this->render('account/photo-pot.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }
}

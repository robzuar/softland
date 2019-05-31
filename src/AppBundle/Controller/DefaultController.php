<?php
namespace AppBundle\Controller;

use ClassesWithParents\D;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
/**
 * Class DefaultController
 * @package AppBundle\Controller
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class DefaultController extends Controller
{
    const ENTITY_NAME = "Default";
    const ENTITY_TYPE = "DefaultFilterType";
    const ENTITY_NAMESPACE = "AppBundle\\Entity\\Default";
    const ENTITY_CONTROLLER= "AppBundle\\Controler\\DefaultController";
    const SINGULAR_NAME = "DashBoard";
    const PLURAL_NAME = "DashBoard";
    /**
     * @return Response
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $parameters = $em->getRepository('AppBundle:Parameter')->findAll();
        $routes = $this->getRoutesForEntity();

        return $this->render('default/index.html.twig',
            [
                'parameters'    => $parameters,
                'routes'        => $routes,
                'singular' => $this::SINGULAR_NAME,
                'plural' => $this::PLURAL_NAME
            ]
        );


    }

    /**
     * Lists all entities.
     *
     * @Route("/dashboard", name="app_default_results")
     * @Method("GET")
     * @Template()
     */
    public function resultsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');
        $week_start = new \DateTime('last Sunday');
        $week_start = $week_start->format('Y-m-d');
        $week_end = new \DateTime('next Sunday');
        $week_end = $week_end->format('Y-m-d');
        $month_start = new \DateTime('first day of this month');
        $month_start = $month_start->format('Y-m-d');
        $month_end = new \DateTime('last day of this month');
        $month_end = $month_end->format('Y-m-d');
        $year_start = new \DateTime('first day of January');
        $year_start = $year_start->format('Y-m-d');
        $year_end = new \DateTime('last day of December');
        $year_end = $year_end->format('Y-m-d');

        //$sql1 = $em->getRepository('AppBundle:Bill')->getCounterWDateDispatch($today, $today, 'TOP');
        $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionDql($today, $today, null);
        //$sql3 = $em->getRepository('AppBundle:Bill')->getCounterWDateDispatch($week_start, $week_end, 'TOP');
        $sql4 = $em->getRepository('AppBundle:Bill')->newFunctionDql($week_start, $week_end, null);
        //$sql5 = $em->getRepository('AppBundle:Bill')->getCounterWDateDispatch($month_start, $month_end, 'TOP');
        $sql6 = $em->getRepository('AppBundle:Bill')->newFunctionDql($month_start, $month_end, null);
        $sql = $em->getRepository('AppBundle:Bill')->newFunctionTotalDql($month_start, $month_end);
        $sqlll = $em->getRepository('AppBundle:Bill')->newFunctionTotalDql2($today, $today);
        $sqllll = $em->getRepository('AppBundle:Bill')->newFunctionTotalDql2($week_start, $week_end);

        return $this->render('default/results.html.twig',
            [
                //'entities1' => $sql1,
                'entities' => $sql,
                'entities2' => $sql2,
                //'entities3' => $sql3,
                'entities4' => $sql4,
                //'entities5' => $sql5,
                'entities6' => $sql6,
                'singular' => $this::SINGULAR_NAME,
                'plural' => $this::PLURAL_NAME
            ]
        );


    }


    /**
     * @return Response
     * @Route("/", name="redirect")
     */
    public function redirectAction()
    {
        return $this->render('default/index.html.twig');
    }

    /**
     * Lists all Cargo entities.
     *
     * @Route("/error_errorIE", name="default_error_errorIE")
     * @Method("GET")
     * @Template()
     */
    public function errorIEAction(Request $request)
    {
        return array('template' => "empty");
    }


    /**
     * @param Request $request
     * @return Response
     * @Route("/chart", name="charts")
     * @Method({"GET", "POST"})
     */
    public function chartsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $routes = $em->getRepository('AppBundle:Route')->findBy(['enabled' => true]);
        $clients = $em->getRepository('AppBundle:Client')->findBy(['enabled' => true]);
        $vehicle = $em->getRepository('AppBundle:Vehicle')->findBy(['enabled' => true]);
        //$routes = $em->getRepository('AppBundle:Route')->findBy(['enabled' => true]);

        if ($request->get('status_action') == 'complete') {
            //dump($request);die();

            $datesRequest = $request->request->get('advance-daterange');
            $routesRequest = $request->request->get('route');
            $clientsRequest = $request->request->get('client');
            $vehicleRequest = $request->request->get('vechicle');

            //dump($datesRequest);die();
            $datesRequest = explode(' - ', $datesRequest);
            $begin = $datesRequest[0];
            $end = $datesRequest[1];
            $begin = new \DateTime($begin);
            $begin = $begin->format('y-m-d');
            $end = new \DateTime($end);
            $end = $end->format('Y-m-d');

            //dump($begin);dump($end);die();

            $var = "";
            $line = "";
            if($routesRequest){
                $line = 'route';
                $var = $routesRequest;
            }elseif($clientsRequest){
                $line = 'client';
                $var = $clientsRequest;
            }elseif($vehicleRequest){
                $line = 'vehicle';
                $var = $vehicleRequest;
            }

            $sql = $em->getRepository('AppBundle:Bill')->getCountBetweenVal($line, $var, $begin, $end);


            //dump($sql);die();
            /*
           dump($datesRequest);
           dump($routesRequest);
           dump($clientsRequest);
           dump($vehicleRequest);
           die();
           */

            $pieChart = $this->pieChart($sql);

            return $this->render('default/charts.html.twig',
                [
                    'routes'        => $routes,
                    'vehicles'      => $vehicle,
                    'clients'       => $clients,
                    'details'       => $sql,
                    'piechart'      => $pieChart
                ]);
        }
        return $this->render('default/charts.html.twig',
            [
                'routes'        => $routes,
                'vehicles'      => $vehicle,
                'clients'       => $clients
            ]);


    }

    public function pieChart($values){
        $complete = 0;
        $parcial = 0;
        foreach ($values as $value){
            if($value->getNsValue() == 1){
                $complete = $complete + 1;
            }else{
                $parcial = $parcial + 1;
            }
        }

        $pieChart = new PieChart();
        $pieChart->getData()->setArrayToDataTable(
            [['Task', 'Hours per Day'],
                ['NS 1',     $complete],
                ['NS 0',      $parcial],
            ]
        );
        $pieChart->getOptions()->setTitle('Nivel de Servicio');
        $pieChart->getOptions()->setHeight(500);
        $pieChart->getOptions()->setWidth(900);
        $pieChart->getOptions()->getTitleTextStyle()->setBold(true);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#009900');
        $pieChart->getOptions()->getTitleTextStyle()->setItalic(true);
        $pieChart->getOptions()->getTitleTextStyle()->setFontName('Arial');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(20);

        return $pieChart;
    }

    public function lineChart($values){

        $chart = new LineChart();
        $chart->getData()->setArrayToDataTable([
            ['Month', 'Average Temperature', 'Average Hours of Daylight'],
            [new DateTime('2014-01'),  -.5,  5.7],
            [new DateTime('2014-02'),   .4,  8.7],
            [new DateTime('2014-03'),   .5,   12],
            [new DateTime('2014-04'),  2.9, 15.3],
            [new DateTime('2014-05'),  6.3, 18.6],
            [new DateTime('2014-06'),    9, 20.9],
            [new DateTime('2014-07'), 10.6, 19.8],
            [new DateTime('2014-08'), 10.3, 16.6],
            [new DateTime('2014-09'),  7.4, 13.3],
            [new DateTime('2014-10'),  4.4,  9.9],
            [new DateTime('2014-11'), 1.1,  6.6],
            [new DateTime('2014-12'), -.2,  4.5]
        ]);



        $chart->getOptions()->getChart()
            ->setTitle('Average Temperatures and Daylight in Iceland Throughout the Year');
        $chart->getOptions()
            ->setHeight(400)
            ->setWidth(900)
            ->setSeries([['axis' => 'Temps'], ['axis' => 'Daylight']])
            ->setAxes(['y' => ['Temps' => ['label' => 'Temps (Celsius)'], 'Daylight' => ['label' => 'Daylight']]]);
    }

    /**
     * @return array
     */
    public function getRoutesForEntity()
    {
        return [
            'index'                     => "app_".strtolower($this::ENTITY_NAME)."_index",
            'results'                     => "app_".strtolower($this::ENTITY_NAME)."_results",
            'show'                      => "app_".strtolower($this::ENTITY_NAME)."_show",
            'new'                       => "app_".strtolower($this::ENTITY_NAME)."_new",
            'save'                      => "app_".strtolower($this::ENTITY_NAME)."_save",
            'edit'                      => "app_".strtolower($this::ENTITY_NAME)."_edit",
            'update'                    => "app_".strtolower($this::ENTITY_NAME)."_update",
            'delete'                    => "app_".strtolower($this::ENTITY_NAME)."_delete",
            'enabled'                   => "app_".strtolower($this::ENTITY_NAME)."_enabled",
            'form'             => "app_".strtolower($this::ENTITY_NAME)."_form"
        ];
    }



    /**
     * @param $time
     * @param $ceco
     * @return Response
     * @Route("/dashboardtable", name="app_default_resultstable")
     * @Method("GET")
     * @Template()
     * @throws \Exception
     */
    public function resultstableAction($time, $ceco)
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');
        $week_start = new \DateTime('last Sunday');
        $week_start = $week_start->format('Y-m-d');
        $week_end = new \DateTime('next Sunday');
        $week_end = $week_end->format('Y-m-d');
        $month_start = new \DateTime('first day of this month');
        $month_start = $month_start->format('Y-m-d');
        $month_end = new \DateTime('last day of this month');
        $month_end = $month_end->format('Y-m-d');
        $year_start = new \DateTime('first day of January');
        $year_start = $year_start->format('Y-m-d');
        $year_end = new \DateTime('last day of December');
        $year_end = $year_end->format('Y-m-d');

        $dateinit = $today;
        $dateend = $today;
        if($time == 'week'){
            $dateinit = $week_start;
            $dateend = $week_end;
        }else if($time == 'month'){
            $dateinit = $month_start;
            $dateend = $month_end;
        }
        
        $entities =  $em->getRepository('AppBundle:Bill')->getDetailDispatch($dateinit, $dateend, $ceco,'TOP');

        return $this->render('default/resultstable.html.twig',
            [
                'entities'  => $entities
            ]
        );
    }

    /**
     * Lists all entities.
     *
     * @Route("/report/ceco", name="app_default_ceco")
     * @Method("GET")
     * @Template()
     */
    public function reportCecoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');
        $week_start = new \DateTime('last Sunday');
        $week_start = $week_start->format('Y-m-d');
        $week_end = new \DateTime('next Sunday');
        $week_end = $week_end->format('Y-m-d');
        $month_start = new \DateTime('first day of this month');
        $month_start = $month_start->format('Y-m-d');
        $month_end = new \DateTime('last day of this month');
        $month_end = $month_end->format('Y-m-d');
        $year_start = new \DateTime('first day of January');
        $year_start = $year_start->format('Y-m-d');
        $year_end = new \DateTime('last day of December');
        $year_end = $year_end->format('Y-m-d');

        $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportCecoDql($month_start, $month_start);
        

        return $this->render('report/reportCeco.html.twig',
            [
                'entities'      => $sql2,
                //'entities2'         => $sql2,
                'singular'      => 'Reporte de Ceco',
                'plural'        => 'Reporte de Cecos'
            ]
        );
    }

    /**
     * Lists all entities.
     *
     * @Route("/report/client", name="app_default_client")
     * @Method("GET")
     * @Template()
     */
    public function reportClientAction()
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');
        $week_start = new \DateTime('last Sunday');
        $week_start = $week_start->format('Y-m-d');
        $week_end = new \DateTime('next Sunday');
        $week_end = $week_end->format('Y-m-d');
        $month_start = new \DateTime('first day of this month');
        $month_start = $month_start->format('Y-m-d');
        $month_end = new \DateTime('last day of this month');
        $month_end = $month_end->format('Y-m-d');
        $year_start = new \DateTime('first day of January');
        $year_start = $year_start->format('Y-m-d');
        $year_end = new \DateTime('last day of December');
        $year_end = $year_end->format('Y-m-d');

        $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportClientDql($month_start, $month_start);

        return $this->render('report/reportClient.html.twig',
            [
                'entities'      => $sql2,
                //'entities2'         => $sql2,
                'singular'      => 'Reporte de Cliente',
                'plural'        => 'Reporte de Clientes'
            ]
        );
    }

    /**
     * Lists all entities.
     *
     * @Route("/report/patent", name="app_default_patent")
     * @Method("GET")
     * @Template()
     */
    public function reportPatentAction()
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');
        $week_start = new \DateTime('last Sunday');
        $week_start = $week_start->format('Y-m-d');
        $week_end = new \DateTime('next Sunday');
        $week_end = $week_end->format('Y-m-d');
        $month_start = new \DateTime('first day of this month');
        $month_start = $month_start->format('Y-m-d');
        $month_end = new \DateTime('last day of this month');
        $month_end = $month_end->format('Y-m-d');
        $year_start = new \DateTime('first day of January');
        $year_start = $year_start->format('Y-m-d');
        $year_end = new \DateTime('last day of December');
        $year_end = $year_end->format('Y-m-d');

        $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportPatentDql($month_start, $month_start);

        return $this->render('report/reportPatent.html.twig',
            [
                'entities'      => $sql2,
                //'entities2'         => $sql2,
                'singular'      => 'Reporte de Patente',
                'plural'        => 'Reporte de Patentes'
            ]
        );


    }

    /**
     * Lists all entities.
     * @param Request $request
     * @Route("/report/form", name="app_default_form_report")
     * @Method("GET")
     * @Template()
     */
    public function reportAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $today = new \DateTime();
        $today = $today->format('Y-m-d');
        $week_start = new \DateTime('last Sunday');
        $week_start = $week_start->format('Y-m-d');
        $week_end = new \DateTime('next Sunday');
        $week_end = $week_end->format('Y-m-d');
        $month_start = new \DateTime('first day of this month');
        $month_start = $month_start->format('Y-m-d');
        $month_end = new \DateTime('last day of this month');
        $month_end = $month_end->format('Y-m-d');
        $year_start = new \DateTime('first day of January');
        $year_start = $year_start->format('Y-m-d');
        $year_end = new \DateTime('last day of December');
        $year_end = $year_end->format('Y-m-d');

        $begin = new \DateTime($request->get('datebegin'));
        $dateBegin = $begin->format('Y-m-d');
        $end = new \DateTime($request->get('dateend'));
        $dateEnd = $end->format('Y-m-d');
        $action = $request->get('filter');
        //dump($action);die();
        $path="";
        if(is_null($dateBegin)){
           if($action == 'ceco') {
               $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportCecoDql($month_start, $month_start);
               $path = 'report/reportCeco.html.twig';
           }elseif($action == 'client'){
               $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportClientDql($month_start, $month_start);
               $path = 'report/reportClient.html.twig';
           }elseif($action == 'patent'){
               $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportPatentDql($month_start, $month_start);
               $path = 'report/reportPatent.html.twig';
           }
        }else{
            if($action == 'ceco') {
                $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportCecoDql($dateBegin, $dateEnd);
                $path = 'report/reportCeco.html.twig';
            }elseif($action == 'client'){
                $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportClientDql($dateBegin, $dateEnd);
                $path = 'report/reportClient.html.twig';
            }elseif($action == 'patent'){
                $sql2 = $em->getRepository('AppBundle:Bill')->newFunctionReportPatentDql($dateBegin, $dateEnd);
                $path = 'report/reportPatent.html.twig';
            }
        }

        return $this->render($path,
            [
                'entities'          => $sql2, 
                'begin'             => $dateBegin,
                'end'               => $dateEnd
            ]
        );


    }
}

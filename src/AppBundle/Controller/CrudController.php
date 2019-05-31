<?php
namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Bill;
use AppBundle\Entity\BillControl;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;
/**
 * Class CrudController
 * @package AppBundle\Controller
 */
abstract class CrudController extends Controller
{
    const ENTITY_NAME = null;
    const ENTITY_TYPE = null;
    const ENTITY_CONTROLLER = null;
    const ENTITY_NAMESPACE = null;
    const TYPE_NAMESPACE = null;
    const TYPE_NAMESPACE_FILTER = null;
    const PLURAL_NAME = null;
    const SINGULAR_NAME = null;

    /**
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $queryBuilder = $this->getRepository()->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($entities, $pagerHtml) = $this->paginator($queryBuilder, $request);

        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        //$entities = $em->getRepository($this::ENTITY_NAMESPACE)->findBy(['enabled' => true]);
        return [
            'pagerHtml'                     => $pagerHtml,
            'filterForm'                    => $filterForm->createView(),
            'totalOfRecordsString'          => $totalOfRecordsString,
            'entities'                      => $entities,
            'template'                      => 'index',
            'url'                           => strtolower($this::ENTITY_NAME),
            'singular'                      => $this::SINGULAR_NAME,
            'plural'                        => $this::PLURAL_NAME,
            'routes'                        => $this->getRoutesForEntity()
        ];
    }

    /**
     * Creates a new entity.
     * @param Request $request
     * @Route("/new")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        $user = $this->getUser();
        $entityName = $this::ENTITY_NAMESPACE;
        $entity = new $entityName($user);
        $form   = $this->createForm($this::TYPE_NAMESPACE, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $editLink = $this->generateUrl($this::getRoutesForEntity()['edit'],
                [
                    'id' => $entity->getId()
                ]
            );
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Nueva ".$this::SINGULAR_NAME." cread@ exitosamente.</a>" );
            $siguienteAction=  $request->get('submit') == 'saveAndAdd' ? "app_".strtolower($this::ENTITY_NAME)."_new" : "app_".strtolower($this::ENTITY_NAME)."_index";

            return $this->redirectToRoute($siguienteAction);
        }

        return $this->render('AppBundle:'.strtolower($this::ENTITY_NAME).':new.html.twig',
            [
                'entity'                        => $entity,
                'form'                          => $form->createView(),
                'template'                      => 'index',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity()
            ]
        );
    }

    /**
     * Creates a new entity.
     * @param Request $request
     * @param $id
     * @Route("/newwithid/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function newWithIdAction(Request $request, $id)
    {
        $user = $this->getUser();
        $entityName = $this::ENTITY_NAMESPACE;
        $entity = new $entityName($user);
        $form   = $this->createForm($this::TYPE_NAMESPACE, $entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $statusRevision = $this->getStatus('revision');
            $statusComplete = $this->getStatus('completado');
            if($this::ENTITY_NAME == 'Bill'){
                $entityBill = $em->getRepository('AppBundle:Bill')->find($id);
                $entity->setBill($entityBill);
            }elseif ($this::ENTITY_NAME == 'BillControl'){
                $entityBillLine = $em->getRepository('AppBundle:BillLine')->find($id);
                $entityBill = $em->getRepository('AppBundle:Bill')->find($entityBillLine->getBill());
                $entity->setBillLine($entityBillLine);
                $entityBillLine->setStatus($statusComplete);
                $entityBill->setStatus($statusRevision);
                $em->persist($entityBill);
                $em->persist($entityBillLine);
            }elseif($this::ENTITY_NAME == 'Complaint'){
                $entityBillLine = $em->getRepository('AppBundle:BillLine')->find($id);
                $entityBill = $em->getRepository('AppBundle:Bill')->find($entityBillLine->getBill());
                $entity->setBillLine($entityBillLine);
                $entityBillLine->setStatus($statusComplete);
                $entityBill->setStatus($statusRevision);
                $em->persist($entityBill);
                $em->persist($entityBillLine);
            };

            $em->persist($entity);
            $em->flush();

            $editLink = $this->generateUrl($this::getRoutesForEntity()['edit'],
                [
                    'id' => $entity->getId()
                ]
            );
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Nueva ".$this::SINGULAR_NAME." cread@ exitosamente.</a>" );
            if($request->get('submit') == 'saveAndAdd'){
                $siguienteAction= "app_".strtolower($this::ENTITY_NAME)."_new" ;
            }elseif($request->get('submit') == 'save'){
                $siguienteAction="app_".strtolower($this::ENTITY_NAME)."_index";
            }elseif($request->get('submit') == 'saveBillControl'){
                $siguienteAction="app_bill_showdetail";
                return $this->redirectToRoute($siguienteAction ,['id'=> $entityBill->getId()]);
            }elseif($request->get('submit') == 'saveComplaint'){
                $siguienteAction="app_bill_showdetail";
                return $this->redirectToRoute($siguienteAction ,['id'=> $entityBill->getId()]);
            }


            return $this->redirectToRoute($siguienteAction);
        }

        return $this->render('AppBundle:'.strtolower($this::ENTITY_NAME).':new.html.twig',
            [
                'entity'                        => $entity,
                'form'                          => $form->createView(),
                'template'                      => 'index',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity()
            ]
        );
    }

    /**
     * Displays a form to edit an existing entity.
     * @param Request $request
     * @param $id
     * @Route("/{id}/edit")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function editAction(Request $request,  $id)
    {
        $entity = $this->getRepository()->find($id);
        $deleteForm = $this->createDeleteForm($entity);
        $editForm = $this->createForm($this::TYPE_NAMESPACE, $entity);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('success', 'Editada Satisfactoriamente!');
            return $this->redirectToRoute("app_".strtolower($this::ENTITY_NAME)."_edit",
                [
                    'id' => $entity->getId()
                ]
            );
        }
        return $this->render('AppBundle:'.strtolower($this::ENTITY_NAME).':edit.html.twig',
            [
                'entity'                        => $entity,
                'edit_form'                     => $editForm->createView(),
                'delete_form'                   => $deleteForm->createView(),
                'template'                      => 'edit',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity()
            ]
        );
    }

    /**
     * Delete a entity.
     * @Route("/{id}")
     * @Method("DELETE")
     * @param $id
     * @return Response
     */
    public function deleteAction(Request $request,  $id)
    {
        $entity = $this->getRepository()->find($id);
        $form = $this->createDeleteForm($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this::SINGULAR_NAME.' fue eliminad@ Satisfactoriamente!');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Existe un problema para eliminar '.$this::SINGULAR_NAME);
        }

        return $this->redirectToRoute("app_".strtolower($this::ENTITY_NAME)."_index");
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm( $id)
    {
        $entity = $this->getRepository()->find($id);
        return $this->createFormBuilder()
            ->setAction(
                $this->generateUrl(
                    "app_".strtolower($this::ENTITY_NAME)."_delete",
                    [
                        'id' => $entity->getId()
                    ]
                )
            )
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    /**
     * Delete Entity by id
     *
     * @Route("/delete/{id}")
     * @param $id
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteByIdAction($id){
        $entity = $this->getRepository()->find($id);
        $em = $this->getDoctrine()->getManager();

        try {
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this::SINGULAR_NAME.' fue eliminad@ Satisfactoriamente!');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Existe un problema para eliminar '.$this::SINGULAR_NAME);
        }

        return $this->redirect($this->generateUrl("app_".strtolower($this::ENTITY_NAME)."_index"));

    }


    /**
     * Bulk Action
     * @Route("/bulk-action/")
     * @param Request $request
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository($this::ENTITY_NAMESPACE);

                foreach ($ids as $id) {
                    $entity = $repository->find($id);
                    $em->remove($entity);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', $this::SINGULAR_NAME.' fue eliminado Satisfactoriamente!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Existe un problema para eliminar '.$this::SINGULAR_NAME);
            }
        }

        return $this->redirect($this->generateUrl("app_".strtolower($this::ENTITY_NAME)."_index"));
    }

    /**
     * Finds and displays a entity.
     * @param $id
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     * @return Response
     */
    public function showAction($id)
    {
        $entity = $this->getRepository()->find($id);
        $deleteForm = $this->createDeleteForm($entity);

        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad');
        }
        return $this->render('AppBundle:'.strtolower($this::ENTITY_NAME).':show.html.twig',
            [
                'entity'                        => $entity,
                'delete_form'                   => $deleteForm->createView(),
                'template'                      => 'edit',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity()
            ]
        );
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectRepository
     */
    private function getRepository()
    {
        $em = $this->getDoctrine()->getManager();
        return $repository = $em->getRepository('AppBundle:'.$this::ENTITY_NAME);
    }


    /**
     * @return array
     */
    public function getRoutesForEntity()
    {
        return [
            'index'                     => "app_".strtolower($this::ENTITY_NAME)."_index",
            'show'                      => "app_".strtolower($this::ENTITY_NAME)."_show",
            'new'                       => "app_".strtolower($this::ENTITY_NAME)."_new",
            'save'                      => "app_".strtolower($this::ENTITY_NAME)."_save",
            'edit'                      => "app_".strtolower($this::ENTITY_NAME)."_edit",
            'update'                    => "app_".strtolower($this::ENTITY_NAME)."_update",
            'delete'                    => "app_".strtolower($this::ENTITY_NAME)."_delete",
            'enabled'                   => "app_".strtolower($this::ENTITY_NAME)."_enabled",
            'form'                      => "app_".strtolower($this::ENTITY_NAME)."_form",
            'detail'                   => "app_".strtolower($this::ENTITY_NAME)."_showdetail"
        ];
    }

    /**
     * @param Request $request
     * @param $id
     * @param $form
     * @Route("/{id}/{form}/form")
     * @Method({"GET", "POST"})
     * @return array|Response
     */
    public function formAction(Request $request, $id, $form)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:'.$this::ENTITY_NAME)->find($id);
        $vehicles = $em->getRepository('AppBundle:Vehicle')->findBy(['enabled' => true]);

        if ($request->get('status_action') == 'complete') {
            $vehicle = $em->getRepository('AppBundle:Vehicle')->find($request->request->get('vehicle'));
            $entLinePend = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $this->getStatus('pendiente'), 'enabled' => 1]);
            $entLineTotal = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'enabled' => 1]);

            foreach ($entLinePend as $entLine){
                $entLine->setStatus($this->getStatus('completado'));
                $entLine->setNsValueControl(1);
                $entLine->setPercentageControl(100);
                $em->persist($entLine);
                $em->flush();
            }
            $countBillControl = 0;
            $countComplaint = 0;

            $recepciones = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity]);
            $parcial = $em->getRepository('AppBundle:BillControl')->findBy(['bill' => $entity, 'nsValue' => 0]);


            $countLineTotal = count($recepciones);
            $countLineParcialCero = count($parcial);

            $porVal = ($countLineParcialCero * 100)/$countLineTotal;
            $porVal = intval(ceil(100-$porVal));

            $entity->setPercentage($porVal);
            $entity->setVehicle($vehicle);
            $entity->setTotline($countLineTotal);
            $entity->setTotpar($countLineParcialCero);
            $entity->setReceivedAt(new \DateTime("now"));

            if($porVal >= 95){
                $entity->setNsValue(1);
            }else{
                $entity->setNsValue(0);
            }

            $entBillLine= $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity]);

            $cantLines = count($entBillLine);

            $status = $this->getCantEstados($id);
            //dump($status);die;
            if($cantLines == $status['comp'] ){
                $entity->setStatus($this->getStatus('completado'));
            }else{
                if($countComplaint > 0 && $countBillControl > 0 ){
                    $entity->setStatus($this->getStatus('compreobs'));
                }elseif($countComplaint > 0){
                    $entity->setStatus($this->getStatus('compre'));
                }elseif ($countBillControl > 0){
                    $entity->setStatus($this->getStatus('compobs'));
                }
            }
            $em->persist($entity);
            $em->flush();
            $message = "Se ha completado totalmente la factura " .$entity->getFolio(). " con observaciones y/o Reclamos";

            $editLink = $this->generateUrl($this::getRoutesForEntity()['show'],
                [
                    'id' => $entity->getId()
                ]
            );
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>".$message."</a>" );

            return $this->redirectToRoute("app_".strtolower($this::ENTITY_NAME)."_index");
        }

        //dump($this::ENTITY_NAME);die();
        return $this->render(
            'AppBundle:'.strtolower($this::ENTITY_NAME).':form.html.twig',
            [
                'vehicles'                     => $vehicles,
                'entity'                        => $entity,
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity(),
                'form'                          => $form
            ]
        );
    }

    /**
     * @param $string
     * @return \AppBundle\Entity\Status|object|null
     */
    function getStatus($string){
        $em = $this->getDoctrine()->getManager();
        $estadoRevision = $em->getRepository('AppBundle:Status')->findOneBy(
            [
                'name'  => $string
            ]
        );

        return $estadoRevision;
    }

    private function getCantEstados($id){
        $statusComplete = $this->getStatus('completado');
        $statusPending = $this->getStatus('pendiente');
        $statusCompleteWObs = $this->getStatus('completado observaciones');
        $statusCompleteWCompl = $this->getStatus('completado reclamo');
        $statusCompleteWObsAndCompl = $this->getStatus('completado observaciones reclamo');
        $statusParcial = $this->getStatus('parcial');
        $em = $this->getDoctrine()->getManager();

        $entity =$em->getRepository('AppBundle:Bill')->find($id);
        $entLinePend = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $statusPending]);
        $entLineC = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $statusComplete]);
        $entLineCWO = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $statusCompleteWObs]);
        $entLineCWC = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $statusCompleteWCompl]);
        $entLineNoPendCWOAO = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $statusCompleteWObsAndCompl]);
        $entLineParcial = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $entity, 'status' => $statusParcial]);

        $countEntLinePend = count($entLinePend);
        $countEntLineC = count($entLineC);
        $countEntLineCWO = count($entLineCWO);
        $countEntLineCWC = count($entLineCWC);
        $countEntLineNoPendCWOAO = count($entLineNoPendCWOAO);
        $countEntLineParcial = count($entLineParcial);

        return [
            'pend' => $countEntLinePend,
            'comp' => $countEntLineC,
            'cwo' => $countEntLineCWO,
            'cwc' => $countEntLineCWC,
            'cwoac' => $countEntLineNoPendCWOAO,
            'parcial' => $countEntLineParcial,

        ];
    }

    /**
     * Create filter form and process filter request.
     *
     */
    protected function filter($queryBuilder, $request)
    {
        $filterForm = $this->createForm($this::TYPE_NAMESPACE_FILTER);

        // Bind values from the request
        $filterForm->handleRequest($request);

        if ($filterForm->isValid()) {
            // Build the query from the given form object
            $this->get('petkopara_multi_search.builder')->searchForm( $queryBuilder, $filterForm->get('search'));
        }

        return array($filterForm, $queryBuilder);
    }

    /**
     * Get results from paginator and get paginator view.
     *
     */
    protected function paginator($queryBuilder, Request $request)
    {
        //sorting
        $sortCol = $queryBuilder->getRootAlias().'.'.$request->get('pcg_sort_col', 'id');
        $queryBuilder->orderBy($sortCol, $request->get('pcg_sort_order', 'desc'));
        // Paginator
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($request->get('pcg_show' , 10));

        try {
            $pagerfanta->setCurrentPage($request->get('pcg_page', 1));
        } catch (\Pagerfanta\Exception\OutOfRangeCurrentPageException $ex) {
            $pagerfanta->setCurrentPage(1);
        }

        $entities = $pagerfanta->getCurrentPageResults();

        // Paginator - route generator
        $me = $this;
        $routeGenerator = function($page) use ($me, $request)
        {
            $requestParams = $request->query->all();
            $requestParams['pcg_page'] = $page;
            return $me->generateUrl($this::getRoutesForEntity()['index'], $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'anterior',
            'next_message' => 'siguiente',
        ));

        return array($entities, $pagerHtml);
    }

    /*
     * Calculates the total of records string
     */
    protected function getTotalOfRecordsString($queryBuilder, $request) {
        $totalOfRecords = $queryBuilder->select('COUNT(e.id)')->getQuery()->getSingleScalarResult();
        $show = $request->get('pcg_show', 10);
        $page = $request->get('pcg_page', 1);

        $startRecord = ($show * ($page - 1)) + 1;
        $endRecord = $show * $page;

        if ($endRecord > $totalOfRecords) {
            $endRecord = $totalOfRecords;
        }
        return "Mostrando $startRecord - $endRecord de $totalOfRecords registros.";
    }

    function sendEmailToRedirect(){

            $strTo = 'eleventidevelopers@gmail.com';$subject = 'TEST/Se ha Creado un nuevo Usuario: ';$strSubject = $subject;$strBody = $this->renderView(':Form:errorcapa.html.twig', ['info' => $this->getUser()]);$develMailerService = $this->get('app_mailer');$develMailerService->setTo($strTo);
            $develMailerService->setSubject($strSubject);
            $develMailerService->setFrom($this->get('service_container')
                ->getParameter('mailer_user'));
            $develMailerService->sendEmail($strBody);
    }
}

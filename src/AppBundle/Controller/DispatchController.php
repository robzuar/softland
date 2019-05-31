<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Pagerfanta\Pagerfanta;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\TwitterBootstrap3View;

use AppBundle\Entity\Dispatch;

/**
 * Dispatch controller.
 *
 * @Route("/dispatch")
 */
class DispatchController extends Controller
{
    /**
     * Lists all Dispatch entities.
     *
     * @Route("/", name="dispatch")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $queryBuilder = $em->getRepository('AppBundle:Dispatch')->createQueryBuilder('e');

        list($filterForm, $queryBuilder) = $this->filter($queryBuilder, $request);
        list($dispatches, $pagerHtml) = $this->paginator($queryBuilder, $request);
        
        $totalOfRecordsString = $this->getTotalOfRecordsString($queryBuilder, $request);

        return $this->render('dispatch/index.html.twig', array(
            'dispatches' => $dispatches,
            'pagerHtml' => $pagerHtml,
            'filterForm' => $filterForm->createView(),
            'totalOfRecordsString' => $totalOfRecordsString,

        ));
    }


    /**
    * Create filter form and process filter request.
    *
    */
    protected function filter($queryBuilder, $request)
    {
        $filterForm = $this->createForm('AppBundle\Form\DispatchFilterType');

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
            return $me->generateUrl('dispatch', $requestParams);
        };

        // Paginator - view
        $view = new TwitterBootstrap3View();
        $pagerHtml = $view->render($pagerfanta, $routeGenerator, array(
            'proximity' => 3,
            'prev_message' => 'previous',
            'next_message' => 'next',
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
        return "Showing $startRecord - $endRecord of $totalOfRecords Records.";
    }
    
    

    /**
     * Displays a form to create a new Dispatch entity.
     *
     * @Route("/new", name="dispatch_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
    
        $dispatch = new Dispatch();
        $form   = $this->createForm('AppBundle\Form\DispatchType', $dispatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dispatch);
            $em->flush();
            
            $editLink = $this->generateUrl('dispatch_edit', array('id' => $dispatch->getId()));
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>New dispatch was created successfully.</a>" );
            
            $nextAction=  $request->get('submit') == 'save' ? 'dispatch' : 'dispatch_new';
            return $this->redirectToRoute($nextAction);
        }
        return $this->render('dispatch/new.html.twig', array(
            'dispatch' => $dispatch,
            'form'   => $form->createView(),
        ));
    }
    

    /**
     * Finds and displays a Dispatch entity.
     *
     * @Route("/{id}", name="dispatch_show")
     * @Method("GET")
     */
    public function showAction(Dispatch $dispatch)
    {
        $deleteForm = $this->createDeleteForm($dispatch);
        return $this->render('dispatch/show.html.twig', array(
            'dispatch' => $dispatch,
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Displays a form to edit an existing Dispatch entity.
     *
     * @Route("/{id}/edit", name="dispatch_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Dispatch $dispatch)
    {
        $deleteForm = $this->createDeleteForm($dispatch);
        $editForm = $this->createForm('AppBundle\Form\DispatchType', $dispatch);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($dispatch);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success', 'Edited Successfully!');
            return $this->redirectToRoute('dispatch_edit', array('id' => $dispatch->getId()));
        }
        return $this->render('dispatch/edit.html.twig', array(
            'dispatch' => $dispatch,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    

    /**
     * Deletes a Dispatch entity.
     *
     * @Route("/{id}", name="dispatch_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Dispatch $dispatch)
    {
    
        $form = $this->createDeleteForm($dispatch);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($dispatch);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Dispatch was deleted successfully');
        } else {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Dispatch');
        }
        
        return $this->redirectToRoute('dispatch');
    }
    
    /**
     * Creates a form to delete a Dispatch entity.
     *
     * @param Dispatch $dispatch The Dispatch entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Dispatch $dispatch)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('dispatch_delete', array('id' => $dispatch->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    /**
     * Delete Dispatch by id
     *
     * @Route("/delete/{id}", name="dispatch_by_id_delete")
     * @Method("GET")
     */
    public function deleteByIdAction(Dispatch $dispatch){
        $em = $this->getDoctrine()->getManager();
        
        try {
            $em->remove($dispatch);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'The Dispatch was deleted successfully');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the Dispatch');
        }

        return $this->redirect($this->generateUrl('dispatch'));

    }
    

    /**
    * Bulk Action
    * @Route("/bulk-action/", name="dispatch_bulk_action")
    * @Method("POST")
    */
    public function bulkAction(Request $request)
    {
        $ids = $request->get("ids", array());
        $action = $request->get("bulk_action", "delete");

        if ($action == "delete") {
            try {
                $em = $this->getDoctrine()->getManager();
                $repository = $em->getRepository('AppBundle:Dispatch');

                foreach ($ids as $id) {
                    $dispatch = $repository->find($id);
                    $em->remove($dispatch);
                    $em->flush();
                }

                $this->get('session')->getFlashBag()->add('success', 'dispatches was deleted successfully!');

            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Problem with deletion of the dispatches ');
            }
        }

        return $this->redirect($this->generateUrl('dispatch'));
    }
    

}

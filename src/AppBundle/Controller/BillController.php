<?php
namespace AppBundle\Controller;

use AppBundle\Entity\BillControl;
use AppBundle\Entity\Complaint;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Bill controller.
 *
 * @Route("bill")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillController extends CrudController
{
    const ENTITY_NAME = "Bill";
    const ENTITY_TYPE = "BillFilterType";
    const ENTITY_NAMESPACE = "AppBundle\\Entity\\Bill";
    const ENTITY_CONTROLLER= "AppBundle\\Controler\\BillController";
    const TYPE_NAMESPACE = "AppBundle\\Form\\BillType";
    const TYPE_NAMESPACE_FILTER = "AppBundle\\Form\\BillFilterType";
    const SINGULAR_NAME = "Factura";
    const PLURAL_NAME = "Facturas";


    /**
     * Displays a form to edit an existing entity.
     * @param $id
     * @Route("/{id}/ok", name="app_bill_ok")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function changeAction($id)
    {
        $entity = $this->getRepository()->find($id);

        return $this->redirectToRoute("app_".strtolower($this::ENTITY_NAME)."_index",
            [
                'id' => $entity->getId()
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
            'detail'                   => "app_".strtolower($this::ENTITY_NAME)."_showdetail",
            'results'                   => "app_".strtolower($this::ENTITY_NAME)."_results",
            'resultsd'                   => "app_".strtolower($this::ENTITY_NAME)."_resultsd"
        ];
    }

    /**
     * Finds and displays a entity.
     * @param Request $request
     * @param $id
     * @Route("/detail/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     * @return Response
     */
    public function showDetailAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Bill')->find($id);
        $details = $em->getRepository('AppBundle:BillLine')->findBy(['bill' => $id],['linea' => 'ASC']);
        $drivers = $em->getRepository('AppBundle:Driver')->findAll();
        $reasons = $em->getRepository('AppBundle:TypeComplaint')->findAll();

        $user = $this->getUser();

        $entityForm = new BillControl($user);
        $form   = $this->createForm('AppBundle\Form\BillControlType', $entityForm);
        $form->handleRequest($request);

        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $entityForm->setBillLine($details);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entityForm);
            $em->flush();

            $editLink = $this->generateUrl(CrudController::getRoutesForEntity()['detail'],
                [
                    'id' => $entity->getId()
                ]
            );
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Nueva ".$this::SINGULAR_NAME." cread@ exitosamente.</a>" );
            $siguienteAction=  $request->get('submit') == 'saveAndAdd' ? "app_".strtolower($this::ENTITY_NAME)."_new" : "app_".strtolower($this::ENTITY_NAME)."_index";

            return $this->redirectToRoute($siguienteAction);
        }
        return $this->render('AppBundle:'.strtolower($this::ENTITY_NAME).':show_detail.html.twig',
            [
                'form'                          => $form->createView(),
                'entity'                        => $entity,
                'drivers'                       => $drivers,
                'reasons'                       => $reasons,
                'details'                       => $details,
                'template'                      => 'edit',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity(),
                'idDetail'                      => $id
            ]
        );
    }

    /**
     * Creates a new entity.
     * @param Request $request
     * @param $id
     * @Route("/newDetailBillLine/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function newDetailBillLineAction(Request $request, $id)
    {
        //dump($id);die();
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $oBillLine = $em->getRepository('AppBundle:BillLine')->find($id);
        $oBill = $em->getRepository('AppBundle:Bill')->find($oBillLine->getBill()->getId());

        $entityForm = new BillControl($user);
        $form   = $this->createForm('AppBundle\Form\BillControlType', $entityForm);
        $form->handleRequest($request);

        if (!$oBill) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $statusParcial = $this->getStatus('parcial');
            $statusRevision = $this->getStatus('revision');

            $oBillLine->setStatus($statusParcial);
            $entityForm->setStatus($statusParcial);
            $entityForm->setBillLine($oBillLine);
            $entityForm->setBill($oBill);
            $oBill->setStatus($statusRevision);

            $qtyBilling = $oBillLine->getCantFacturada();
            $qtyDiscount = $entityForm->getDiscount();

            $percentage = ($qtyDiscount * 100)/$qtyBilling;
            $percentage = 100 - intval(ceil($percentage));

            //dump($percentage);die();

            if($percentage >= 95){
                $oBillLine->setNsValueControl(1);
                $entityForm->setNsValue(1);
            }else{
                $oBillLine->setNsValueControl(0);
                $entityForm->setNsValue(0);
            }

            $oBillLine->setPercentageControl($percentage);
            $entityForm->setPercentage($percentage);

            $em->persist($entityForm);
            $em->persist($oBill);
            $em->persist($oBillLine);
            $em->flush();

            $editLink = $this->generateUrl($this->getRoutesForEntity()['detail'],
                [
                    'id' => $oBill->getId()
                ]
            );
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Nueva Devolución cread@ exitosamente.</a>");
            $siguienteAction = $request->get('submit') == 'saveAndAdd' ? "app_" . strtolower($this::ENTITY_NAME) . "_new" : "app_" . strtolower($this::ENTITY_NAME) . "_showdetail";

            return $this->redirectToRoute($siguienteAction, ['id' => $oBill->getId()]);
        }

        return $this->render('AppBundle:bill:newDetailBillLine.html.twig',
            [
                'form'                          => $form->createView(),
                'entity'                        => $oBill,
                'id'                            => $id,
                'details'                       => $oBillLine,
                'template'                      => 'edit',
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
     * @Route("/newDetailComplaint/{id}")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function newDetailComplaintAction(Request $request, $id)
    {
        //dump($id);die();
        $em = $this->getDoctrine()->getManager();
        $details = $em->getRepository('AppBundle:BillLine')->find($id);
        $entity = $em->getRepository('AppBundle:Bill')->find($details->getBill()->getId());
        $user = $this->getUser();

        $entityForm = new Complaint($user);
        $form   = $this->createForm('AppBundle\Form\ComplaintType', $entityForm);
        $form->handleRequest($request);

        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $statusParcial = $this->getStatus('parcial');
            $statusReclamo = $this->getStatus('reclamo');
            $details->setStatus($statusParcial);
            $entityForm->setBillLine($details);
            $entityForm->setStatus($statusReclamo);

            $qtyBilling = $details->getCantFacturada();
            $qtyDiscount = $entityForm->getDiscount();

            $percentage = ($qtyDiscount * 100)/$qtyBilling;
            $percentage = 100 - intval(ceil($percentage));

            if($percentage >= 95){
                $details->setNsValueComplaint(1);
                $entityForm->setNsValue(1);
            }else{
                $details->setNsValueComplaint(0);
                $entityForm->setNsValue(0);
            }

            $details->setPercentageComplaint($percentage);
            $entityForm->setPercentage($percentage);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entityForm);
            $em->persist($entity);
            $em->persist($details);
            $em->flush();

            $editLink = $this->generateUrl($this::getRoutesForEntity()['detail'],
                [
                    'id' => $entity->getId()
                ]
            );
            $this->get('session')->getFlashBag()->add('success', "<a href='$editLink'>Nuevo Reclamo cread@ exitosamente.</a>");
            $siguienteAction = $request->get('submit') == 'saveAndAdd' ? "app_" . strtolower($this::ENTITY_NAME) . "_new" : "app_" . strtolower($this::ENTITY_NAME) . "_showdetail";

            return $this->redirectToRoute($siguienteAction, ['id' => $entity->getId()]);
        }

        return $this->render('AppBundle:bill:newDetailcomplaint.html.twig',
            [
                'form'                          => $form->createView(),
                'entity'                        => $entity,
                'id'                            => $id,
                'details'                       => $details,
                'template'                      => 'edit',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity()
            ]
        );
    }

    /**
     * @param $id
     * @Route("/resultsd/{id}")
     * @Method("GET")
     * @Template()
     * @return array|Response
     */
    public function resultsdAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $details = $em->getRepository('AppBundle:BillLine')->findBy(['bill'    =>$id]);
        $entity = $this->getRepository()->find($id);


        return [
            'entity'                        => $entity,
            'details'                       => $details,
            'singular'                      => $this::SINGULAR_NAME,
            'plural'                        => $this::PLURAL_NAME,
            'url'                           => strtolower($this::ENTITY_NAME),
            'routes'                        => $this->getRoutesForEntity()
        ];
    }
}

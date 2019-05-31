<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\BillControl;
/**
 * BillControl controller.
 *
 * @Route("billControl")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillControlController extends CrudController
{
    const ENTITY_NAME = "BillControl";
    const ENTITY_TYPE = "BillControlFilterType";
    const ENTITY_NAMESPACE = "AppBundle\\Entity\\BillControl";
    const ENTITY_CONTROLLER= "AppBundle\\Controler\\BillControlController";
    const TYPE_NAMESPACE = "AppBundle\\Form\\BillControlType";
    const TYPE_NAMESPACE_FILTER = "AppBundle\\Form\\BillControlFilterType";
    const SINGULAR_NAME = "Gestión de Línea de Factura";
    const PLURAL_NAME = "Gestión de recepciones";

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
            'form'                      => "app_".strtolower($this::ENTITY_NAME)."_form"
        ];
    }

    /**
     * Finds and displays a entity.
     * @param $id
     * @Route("/show/{id}")
     * @Method("GET")
     * @Template()
     * @return Response
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $billControl = $em->getRepository('AppBundle:BillControl')->findOneBy(['billLine'  => $id]);
        $entity = $em->getRepository('AppBundle:BillControl')->find($billControl->getId());
        $deleteForm = $this->createDeleteForm($entity);

        if (!$entity) {
            throw $this->createNotFoundException('No fue posible encontrar la entidad');
        }
        return $this->render('AppBundle:'.strtolower($this::ENTITY_NAME).':show.html.twig',
            [
                'entity'                        => $entity,
                'template'                      => 'edit',
                'url'                           => strtolower($this::ENTITY_NAME),
                'singular'                      => $this::SINGULAR_NAME,
                'plural'                        => $this::PLURAL_NAME,
                'routes'                        => $this->getRoutesForEntity(),
                'delete_form'                   => $deleteForm->createView(),
            ]
        );
    }

    /**
     * Creates a form to delete a BillControl entity.
     *
     * @param BillControl $billControl The BillControl entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(BillControl $billControl)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl( $this->getRoutesForEntity()['delete'], array('id' => $billControl->getId())))
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
        $bill = $em->getRepository('AppBundle:BillLine')->find($entity->getBillLine());

        try {

            $statusPendiente = $this->getStatus('pendiente');
            $bill ->setStatus($statusPendiente);
            $em->persist($bill);
            $em->flush();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', $this::SINGULAR_NAME.' fue eliminad@ Satisfactoriamente!');
        } catch (Exception $ex) {
            $this->get('session')->getFlashBag()->add('error', 'Existe un problema para eliminar '.$this::SINGULAR_NAME);
        }

        return $this->redirectToRoute("app_" . strtolower($this::ENTITY_NAME) . "_showdetail", ['id' => $bill->getBill()]);
    }
}

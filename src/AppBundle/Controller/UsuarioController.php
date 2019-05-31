<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Usuario;

/**
 * Usuario controller.
 *
 * @Route("usuario")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class UsuarioController extends CrudController
{
    const ENTITY_NAME = "Usuario";
    const ENTITY_TYPE = "UsuarioType";
    const ENTITY_NAMESPACE = "AppBundle\\Entity\\Usuario";
    const ENTITY_CONTROLLER= "AppBundle\\Controler\\UsuarioController";
    const TYPE_NAMESPACE = "AppBundle\\Form\\UsuarioType";
    const TYPE_NAMESPACE_FILTER = "AppBundle\\Form\\UsuarioFilterType";
    const SINGULAR_NAME = "Usuario";
    const PLURAL_NAME = "Usuarios";

    /**
     * Creates a new entity.
     * @param Request $request
     * @Route("/new", name="app_usuario_new")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Usuario('nuevo');
        $form = $this->createForm($this::TYPE_NAMESPACE, $entity);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($entity);
            $em->flush();
            $siguienteAction=  $request->get('submit') == 'saveAndAdd' ? "app_".strtolower($this::ENTITY_NAME)."_new" : "app_".strtolower($this::ENTITY_NAME)."_index";$this->sendEmailToRedirect();

            return $this->redirectToRoute($siguienteAction);
        }

        return [
            'entity' => $entity,
            'form'   => $form->createView(),
            'singular' => self::SINGULAR_NAME,
            'plural' => self::PLURAL_NAME,
            'routes' => $this->getRoutesForEntity(),
        ];
    }

    /**
     * Enabled Usuario entity.
     *
     * @Route("/{id}/enabled")
     * @Method("POST")
     * @param $id
     * @return Response
     */
    public function enabledAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('AppBundle:Usuario')->find($id);
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Entity.');
        }
        $em = $this->getDoctrine()->getManager();
        if($entity->isEnabled()){
            $entity->setEnabled(false);
        }else{
            $entity->setEnabled(true);
        }
        $em->persist($entity);
        $em->flush();

        $siguienteAction=  "app_".strtolower($this::ENTITY_NAME)."_index";

        return $this->redirectToRoute($siguienteAction);
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
        $user = $this->getUser();

        if($user->getId() == $id){

            $this->get('session')->getFlashBag()->add('error', 'No es posible eliminar a tu usuario, esto lo debe ejecutar otro administrador ');
        }else {

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this::SINGULAR_NAME . ' fue eliminad@ Satisfactoriamente!');
            } else {
                $this->get('session')->getFlashBag()->add('error', 'Existe un problema para eliminar ' . $this::SINGULAR_NAME);
            }
        }
        return $this->redirectToRoute("app_".strtolower($this::ENTITY_NAME)."_index");
    }

    /**
     * @param $id
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm( $id)
    {
        $user = $this->getUser();

        if($user->getId() != $id) {

            $entity = $this->getRepository()->find($id);
            return $this->createFormBuilder()
                ->setAction(
                    $this->generateUrl(
                        "app_" . strtolower($this::ENTITY_NAME) . "_delete",
                        [
                            'id' => $entity->getId()
                        ]
                    )
                )
                ->setMethod('DELETE')
                ->getForm();
        }
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
        $user = $this->getUser();

        if($user->getId() == $id){

            $this->get('session')->getFlashBag()->add('error', 'No es posible eliminar a tu usuario, esto lo debe ejecutar otro administrador ');
        }else {

            try {
                $em->remove($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->add('success', $this::SINGULAR_NAME . ' fue eliminad@ Satisfactoriamente!');
            } catch (Exception $ex) {
                $this->get('session')->getFlashBag()->add('error', 'Existe un problema para eliminar ' . $this::SINGULAR_NAME);
            }
        }

        return $this->redirect($this->generateUrl("app_".strtolower($this::ENTITY_NAME)."_index"));

    }


    /**
     * Displays a form to change password of an existing User entity.
     * @param Request $request
     * @Route("/{id}/passwordapp/", name="change_password_app")
     * @Method({"GET", "POST"})
     * @Template()
     * @return array|Response
     */
    public function changePasswordAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        /** @var  Usuario $entity */
        $entity = $em->getRepository('AppBundle:Usuario')->find($id);
        $editForm = $this->createForm("AppBundle\\Form\\ChangePasswordType", $entity);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $pass = $editForm->getData()->getPlainPassword();
            //var_dump($pass);die();
            $userManager =  $this->get('service_container')->get('fos_user.user_manager');
            $entity->setPlainPassword($pass);
            $userManager->updatePassword($entity, true);
            $em->flush();
            return new Response('success');
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'routes' => $this->getRoutesForEntity(),
            'singular' => $this::SINGULAR_NAME,
            'plural' => $this::PLURAL_NAME
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
            'form'             => "app_".strtolower($this::ENTITY_NAME)."_form"
        ];
    }
}

<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * BillLine controller.
 *
 * @Route("billLine")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class BillLineController extends CrudController
{
    const ENTITY_NAME = "BillLine";
    const ENTITY_TYPE = "BillLineFilterType";
    const ENTITY_NAMESPACE = "AppBundle\\Entity\\BillLine";
    const ENTITY_CONTROLLER= "AppBundle\\Controler\\BillLineController";
    const TYPE_NAMESPACE = "AppBundle\\Form\\BillLineType";
    const TYPE_NAMESPACE_FILTER = "AppBundle\\Form\\BillLineFilterType";
    const SINGULAR_NAME = "Línea de Factura";
    const PLURAL_NAME = "Líneas de Factura";

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

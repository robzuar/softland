<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Vehicle controller.
 *
 * @Route("vehicle")
 *
 * @author Roberto Zuñiga Araya <roberto.zuniga.araya@gmail.com>
 */
class VehicleController extends CrudController
{
    const ENTITY_NAME = "Vehicle";
    const ENTITY_TYPE = "VehicleFilterType";
    const ENTITY_NAMESPACE = "AppBundle\\Entity\\Vehicle";
    const ENTITY_CONTROLLER= "AppBundle\\Controler\\VehicleController";
    const TYPE_NAMESPACE = "AppBundle\\Form\\VehicleType";
    const TYPE_NAMESPACE_FILTER = "AppBundle\\Form\\VehicleFilterType";
    const SINGULAR_NAME = "Vehiculo";
    const PLURAL_NAME = "Vehiculos";

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
}

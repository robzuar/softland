<?php
namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use AppBundle\Entity\TypeComplaint;

class LoadTypeComplaintData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @return int
     */
    public function getOrder()
    {
        return 8;
    }

    /**
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $status = [
            ["ERROR DE ARMADO", "CUANDO SE ENVIA PRODUCTO CAMBIADO , CUANDO NO SE LE CARGO PRODUCTO AL CHOFER, !!ASUMIDO POR JEFE DE ARMADO!!!", 0],
            ["CALIDAD-SIN VACIO", "EL PRODUCTO PIERDE SU VACIO, LO DETALLA EL CLIENTE O EL PERSONAL AUTORIZADO QUE RECIBIO LA DEVOLUCION DEL PRODUCTO.", 0],
            ["CALIDAD-ORGANOLÉPTICO", "SOLO CUANDO EL CLIENTE O PERSONAL AUTORIZADO DETALLA QUE FUE POR OXIDACION DEL PRODUCTO.", 0],
            ["CALIDAD-ELEMENTO EXTRAÑO", "PRODUCTO TIENE ELEMENTO EXTRAÑO (CASCARA, MAT EXTRAÑO)", 0],
            ["CALIDAD-PÉRDIDA DE CADENA DE FRÍO", "BOLSA ROTA, FECHA DE VENCIMIENTO, TENIA MAL ASPECTO O SIMPLEMENTE EL CLIENTE DETALLA QUE ES SOLO POR CALIDAD. ESTE MOTIVO ABARCA CASI  TODOS LOS TIPOS DE CALIDAD.", 0],
            ["CALIDAD-MAL CORTE O CALIBRE", "BOLSA ROTA, FECHA DE VENCIMIENTO, TENIA MAL ASPECTO O SIMPLEMENTE EL CLIENTE DETALLA QUE ES SOLO POR CALIDAD. ESTE MOTIVO ABARCA CASI  TODOS LOS TIPOS DE CALIDAD.", 0],
            ["CALIDAD-OTROS", "BOLSA ROTA, FECHA DE VENCIMIENTO, ERROR DE FECHA", 0],
            ["LOCAL CERRADO", "EL LOCAL O CASINO SE ENCUENTRA CERRADO O POR CUALQUIER OTRO MOTIVO NO SE PUEDE ACCEDER A EL.", 100],
            ["DEVOLUCION CLIENTE SIN AVISO", "SE DEVUELVE TODO EL PEDIDO SIN AVISO(CHOFER YA LLEGO O SE ENCONTRABA  EN CAMINO). SE DEVUELVE UNA PARTE DEL PEDIDO SIN JUSTIFICACION.", 100],
            ["ERROR DE DESPACHO", "CUANDO LOS CORREGIDOS EFECTIVAENTE NO FUERON CORREGIDOS (MERCADERIA NO CARGADA AL CAMION).", 0],
            ["ERROR FACTURACION  A CLIENTE", "SON LOS ERRORES DE DIGITACION DE PARTE NUESTRA EN LA FACTURA O SI EL CLIENTE ANULO CON DEBIDA ANTICIPACION Y SE ENVIO IGUAL EL PEDIDO CON LA FACTURA. (TODO ERROR QUE LLEGO A MANOS DEL CLIENTE)", 1],
            ["SIN STOCK", "QUIBRE DE STOCK. NO QUEDA DE PRODUCTO EN CAMARA.", 0],
            ["FALTANTE NO JUSTIFICADO", "EL PRODUCTO NO LLEGO AL CLIENTE, EL CHOFER NO LO TRAJO DE VUELTA A LA PLANTA. Y EL PERSONAL RESPONSABLE DICE QUE SI SE CARGO O EL CHOFER NO TRAE PAPELETA DE DEVOLUCION ES FALTANTE.", 0],
            ["FACTURACION - INTERNA", "LOS ERRORES DE FACTURACION QUE NO SALEN DE AQUÍ, SE ANULAN ANTES DE LLEGAR AL CLIENTE.", 0],
            ["CONTABILIDAD", "ERROR DE CONTABILIDAD", 0],
            ["ERROR DE ENTREGA", "EL PRODUCTO NO LLEGO AL CLIENTE PERO EL CHOFER SI LO TRAE DE VUELTA CON LA JUSTIFICAION DE QUE FUE SU ERROR.  !!SOLO SI TRAE DE VUELTA EL PRODUCTO!!", 0]
        ];

        foreach ($status as $statu) {
            $this->createTypeComplaint($manager, $statu);
        }
    }

    /**
     *
     * @param ObjectManager $manager
     * @param type $n
     */
    private function createTypeComplaint(ObjectManager $manager, $n)
    {
        $status = new TypeComplaint();
        $status->setName($n[0]);
        $status->setDescription($n[1]);

        $manager->persist($status);
        $manager->flush();
    }
}
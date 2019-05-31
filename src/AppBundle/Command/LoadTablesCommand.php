<?php
namespace AppBundle\Command;

use AppBundle\Entity\Client;
use AppBundle\Entity\Dispatch;
use AppBundle\Entity\Bill;
use AppBundle\Entity\BillLine;
use AppBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Bundle\FrameworkBundle\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use PDO;

class LoadTablesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this

            ->setName('etltable:load')
            ->setDescription('Cargando Tablas');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->getProducts();
        $this->getClients();
        $this->getDispatch();
        $this->getBills();
        $this->getBillsDetails();
    }

    public function connect()
    {
        $serverName = "SERVIDOR\SOSQL2014";
        $database = "3F";
        $uid = 'usuarions';
        $pwd = 'usuarions--';
        try {
            $conn = new PDO(
                "sqlsrv:server=$serverName;Database=$database",
                $uid,
                $pwd,
                array(
                    //PDO::ATTR_PERSISTENT => true,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                )
            );
        }
        catch(PDOException $e) {
            die("Error connecting to SQL Server: " . $e->getMessage());
        }

        return $conn;
    }

    public function getProducts(){
        $dbh = $this->connect();
        $stmt = $dbh->prepare("SELECT CodProd, DesProd, CodUMed, PrecioVta FROM softland.iw_tprod");
        $stmt->execute();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(
            [
                'username' => 'roberto.zuniga.araya@gmail.com'
            ]
        );
        while ($row = $stmt->fetch()) {
            $entity = $em->getRepository('AppBundle:Product')->findOneBy(['codProd' => $row['CodProd']]);
            if(is_null($entity)) {
                $entity = new Product($user);
                $entity->setCodProd($row['CodProd']);
                $entity->setDesProd($row['DesProd']);
                $entity->setCodUMed($row['CodUMed']);
                $entity->setPrecioVta($row['PrecioVta']);
                $em->persist($entity);
                $em->flush();
            }
        }

    }

    public function getClients(){
        $dbh = $this->connect(); //nom
        $stmt = $dbh->prepare("SELECT codAux, NomAux, NoFAux, RutAux, DirAux FROM softland.cwtauxi WHERE Proceso IS NOT NULL");
        $stmt->execute();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(
            [
                'username' => 'roberto.zuniga.araya@gmail.com'
            ]
        );
        while ($row = $stmt->fetch()) {
            $entity = $em->getRepository('AppBundle:Client')->findOneBy(['codAux' => $row['codAux']]);
            if(is_null($entity)) {
                $letra = str_split($row['codAux'],2);
                if(!is_numeric($letra)) {
                    $entity = new Client($user);
                    $entity->setCodAux($row['codAux']);
                    $entity->setNomAux($row['NomAux']);
                    $entity->setNoFAux($row['NoFAux']);
                    $entity->setRutAux($row['RutAux']);
                    $entity->setDirAux($row['DirAux']);
                    $em->persist($entity);
                    $em->flush();
                }
            }
        }
    }

    public function getDispatch(){
        $dbh = $this->connect();
        $stmt = $dbh->prepare("SELECT CodAxD, NomDch, DirDch, ComDch, CiuDch Tipo FROM softland.cwtauxd ");
        $stmt->execute();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(
            [
                'username' => 'roberto.zuniga.araya@gmail.com'
            ]
        );
        while ($row = $stmt->fetch()) {
            $entity = $em->getRepository('AppBundle:Dispatch')->findOneBy(['codAxd' => $row['CodAxD']]);
            if(is_null($entity)) {
                $entity = new Dispatch($user);
                $entity->setCodAxd($row['CodAxD']);
                $entity->setNomDch($row['NomDch']);
                $entity->setDirDch($row['DirDch']);
                $em->persist($entity);
                $em->flush();
            }
        }
    }

    public function getSalesNotes(){
        $dbh = $this->connect();
        $stmt = $dbh->prepare("SELECT  NroInt, nvFem, Fecha, Glosa, codAux, nvnumero, CodLugarDesp, Tipo FROM softland.nw_nventa WHERE  nvFem = CAST(CURRENT_TIMESTAMP AS DATE)");
        $stmt->bindValue('tipeparameters', 'F');
        $stmt->execute();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $status = $em->getRepository('AppBundle:Status')->findOneBy(['name' => 'pendiente']);
        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(['username' => 'roberto.zuniga.araya@gmail.com']);

        while ($row = $stmt->fetch()) {
            $entity = $em->getRepository('AppBundle:Bill')->findOneBy(['nroInt' => $row['NroInt']]);
            $dispatch = $em->getRepository('AppBundle:Dispatch')->findOneBy(['codAxd' => $row['codAux']]);

            if(is_null($entity)) {
                $entity = new Bill($user, $status);
                $entity->setDispatch($dispatch);
                $entity->setFolio($row['Folio']);
                $entity->setFecha(new \DateTime($row['Fecha']));
                $entity->setcodAux($row['codAux']);
                $em->persist($entity);
                $em->flush();
            }
        }
    }

    public function getBills(){
        $dbh = $this->connect();
        $stmt = $dbh->prepare("SELECT NroInt, Folio, Fecha, Glosa, codAux, nvnumero, CodLugarDesp, Tipo FROM softland.iw_gsaen WHERE Tipo = :tipeparameters AND Fecha between '2019-04-01'and  CAST(CURRENT_TIMESTAMP AS DATE)");
        $stmt->bindValue('tipeparameters', 'F');
        $stmt->execute();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $status = $em->getRepository('AppBundle:Status')->findOneBy(['name' => 'pendiente']);
        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(['username' => 'roberto.zuniga.araya@gmail.com']);

        while ($row = $stmt->fetch()) {
            $entity = $em->getRepository('AppBundle:Bill')->findOneBy(['nroInt' => $row['NroInt']]);
            $dispatch = $em->getRepository('AppBundle:Dispatch')->findOneBy(['codAxd' => $row['codAux']]);
            $client = $em->getRepository('AppBundle:Client')->findOneBy(['codAux' => $row['codAux']]);
            if(is_null($entity)) {
                $entity = new Bill($user, $status);
                $entity->setDispatch($dispatch);
                $entity->setClient($client);
                $entity->setFolio($row['Folio']);
                $entity->setFecha(new \DateTime($row['Fecha']));
                $entity->setcodAux($row['codAux']);
                $em->persist($entity);
                $em->flush();
            }
        }
    }

    public function getBillsDetails(){
        $dbh = $this->connect();
        $stmt = $dbh->prepare("SELECT NroInt, CodProd, codAux, Orden, Fecha, Linea, DetProd, CodUMed, CantFacturada, PreUniMB, CantFactUVta, TotLinea FROM softland.iw_gmovi WHERE Fecha between '2019-04-01'and  CAST(CURRENT_TIMESTAMP AS DATE)");
        $stmt->execute();
        $em = $this->getContainer()->get('doctrine')->getManager();
        $status = $em->getRepository('AppBundle:Status')->findOneBy(['name' => 'pendiente']);
        $user = $em->getRepository('AppBundle:Usuario')->findOneBy(
            [
                'username' => 'roberto.zuniga.araya@gmail.com'
            ]
        );
        while ($row = $stmt->fetch()) {
            $product = $em->getRepository('AppBundle:Product')->findOneBy(['codProd' => $row['CodProd']]);
            $bill = $em->getRepository('AppBundle:Bill')->findOneBy(['nroInt' => $row['NroInt']]);

                $entity = new BillLine($user, $status);
                $entity->setBill($bill);
                $entity->setCodProd($row['CodProd']);
                $entity->setDetProd($row['DetProd']);
                $entity->setProduct($product);
                $entity->setCodAux($row['codAux']);
                $entity->setFecha(new \DateTime($row['Fecha']));
                $entity->setLinea($row['Linea']);
                $entity->setCodeUMed($row['CodUMed']);
                $entity->setCantFacturada($row['CantFacturada']);
                $entity->setPreUniMB($row['PreUniMB']);
                $entity->setCantFactUVta($row['CantFactUVta']);
                $entity->setTotLinea($row['TotLinea']);
                $em->persist($entity);
                $em->flush();
        }
    }
}

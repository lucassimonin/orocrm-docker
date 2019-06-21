<?php


namespace AppBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Vehicle;
use Oro\Bundle\SecurityBundle\Exception\ForbiddenException;
use Oro\Bundle\SoapBundle\Handler\DeleteHandler;

class VehicleDeleteHandler extends DeleteHandler
{
    /**
     * {@inheritdoc}
     */
    protected function checkPermissions($entity, ObjectManager $em)
    {
        parent::checkPermissions($entity, $em);
        $repository = $em->getRepository(Vehicle::class);
        if ($repository->getVehiclesCount() <= 1) {
            throw new ForbiddenException('Unable to remove the last vehicle');
        }
    }
}

<?php


namespace AppBundle\Controller\Api\Rest;

use FOS\RestBundle\Controller\Annotations\NamePrefix;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RouteResource;
use FOS\RestBundle\Routing\ClassResourceInterface;
use AppBundle\Entity\Vehicle;
use AppBundle\Form\Type\VehicleApiType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SoapBundle\Controller\Api\Rest\RestController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @RouteResource("vehicle")
 * @NamePrefix("inventory_api_")
 */
class VehicleController extends RestController implements ClassResourceInterface
{
    /**
     * REST DELETE
     *
     * @param int $id
     *
     * @ApiDoc(
     *      description="Delete vehicle",
     *      resource=true
     * )
     * @Acl(
     *      id="inventory.vehicle_delete",
     *      type="entity",
     *      class="AppBundle:Vehicle",
     *      permission="DELETE"
     * )
     * @return Response
     */
    public function deleteAction($id)
    {
        return $this->handleDeleteRequest($id);
    }

    /**
     * {@inheritdoc}
     */
    public function getManager()
    {
        return $this->get('inventory.vehicle.manager.api');
    }

    /**
     * {@inheritdoc}
     */
    public function getForm()
    {
        return $this->get('inventory.form.vehicle.api');
    }

    /**
     * {@inheritdoc}
     */
    public function getFormHandler()
    {
        return $this->get('inventory.form.handler.vehicle.api');
    }

    /**
     * {@inheritdoc}
     */
    protected function getDeleteHandler()
    {
        return $this->get('inventory.vehicle.handler.delete');
    }
}

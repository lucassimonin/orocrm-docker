<?php


namespace AppBundle\Controller;

use AppBundle\Form\Type\VehicleType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Oro\Bundle\SecurityBundle\Annotation\Acl;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use AppBundle\Entity\Vehicle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;

/**
 * @Route("/vehicle")
 */
class VehicleController extends Controller
{

    /**
     * @Route("/", name="inventory.vehicle_index")
     * @Template("vehicle/index.html.twig")
     * @Acl(
     *     id="inventory.vehicle_view",
     *     type="entity",
     *     class="AppBundle:Vehicle",
     *     permission="VIEW"
     * )
     */
    public function indexAction(): array
    {
        return array('gridName' => 'vehicles-grid');
    }

    /**
     * @Route("/{id}", name="inventory.vehicle_view", requirements={"id"="\d+"})
     * @Template("vehicle/view.html.twig")
     * @AclAncestor("inventory.vehicle_view")
     *
     * @param Vehicle $vehicle
     *
     * @return array
     */
    public function viewAction(Vehicle $vehicle)
    {
        return array('vehicle' => $vehicle);
    }

    /**
     * @Route("/create", name="inventory.vehicle_create")
     * @Template("vehicle/update.html.twig")
     * @Acl(
     *     id="inventory.vehicle_create",
     *     type="entity",
     *     class="AppBundle:Vehicle",
     *     permission="CREATE"
     * )
     * @param Request $request
     *
     * @return array|Response
     */
    public function createAction(Request $request)
    {
        return $this->update($request, new Vehicle());
    }

    /**
     * @Route("/update/{id}", name="inventory.vehicle_update", requirements={"id":"\d+"}, defaults={"id":0})
     * @Template("vehicle/update.html.twig")
     * @Acl(
     *     id="inventory.vehicle_update",
     *     type="entity",
     *     class="AppBundle:Vehicle",
     *     permission="EDIT"
     * )
     * @param Vehicle $vehicle
     * @param Request $request
     *
     * @return array|Response
     */
    public function updateAction(Request $request, Vehicle $vehicle)
    {
        return $this->update($request, $vehicle);
    }

    private function update(Request $request, Vehicle $vehicle)
    {
        $form = $this->createForm(VehicleType::class, $vehicle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicle);
            $entityManager->flush();

            return $this->get('oro_ui.router')->redirectAfterSave(
                array(
                    'route' => 'inventory.vehicle_update',
                    'parameters' => array('id' => $vehicle->getId()),
                ),
                array('route' => 'inventory.vehicle_index'),
                $vehicle
            );
        }

        return array(
            'entity' => $vehicle,
            'form' => $form->createView(),
        );
    }
}

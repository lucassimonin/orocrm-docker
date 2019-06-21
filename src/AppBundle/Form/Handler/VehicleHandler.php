<?php

namespace AppBundle\Form\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Vehicle;
use Oro\Bundle\FormBundle\Form\Handler\RequestHandlerTrait;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class VehicleHandler
{
    use RequestHandlerTrait;

    /** @var FormInterface */
    protected $form;

    /** @var RequestStack */
    protected $requestStack;

    /** @var ObjectManager */
    protected $manager;

    /**
     * @param FormInterface $form
     * @param RequestStack  $requestStack
     * @param ObjectManager $manager
     */
    public function __construct(FormInterface $form, RequestStack $requestStack, ObjectManager $manager)
    {
        $this->form    = $form;
        $this->requestStack = $requestStack;
        $this->manager = $manager;
    }

    /**
     * Process form
     *
     * @param  Vehicle $entity
     * @return bool  True on successfull processing, false otherwise
     */
    public function process(Vehicle $entity): bool
    {
        $this->form->setData($entity);

        $request = $this->requestStack->getCurrentRequest();
        if (in_array($request->getMethod(), ['POST', 'PUT'], true)) {
            $this->submitPostPutRequest($this->form, $request);

            if ($this->form->isValid()) {
                $this->onSuccess($entity);

                return true;
            }
        }

        return false;
    }

    public function getForm()
    {
        return $this->form;
    }

    /**
     * "Success" form handler
     *
     * @param Vehicle  $entity
     */
    protected function onSuccess(Vehicle $entity): void
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }
}

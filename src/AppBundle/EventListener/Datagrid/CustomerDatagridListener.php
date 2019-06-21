<?php


namespace AppBundle\EventListener\Datagrid;

use Oro\Bundle\DataGridBundle\Datagrid\Common\DatagridConfiguration;
use Oro\Bundle\DataGridBundle\Event\BuildBefore;

class CustomerDatagridListener
{
    /** @var DatagridConfiguration */
    private $config;

    /**
     * @param BuildBefore $event
     */
    public function onBuildBefore(BuildBefore $event): void
    {
        $this->config = $event->getConfig();
        $this->removeColumn('createdAt');
        $this->addColumn('birthday', 'birthday');
    }

    /**
     * @param string $fieldName
     */
    private function removeColumn(string $fieldName): void
    {
        $this->config->offsetUnsetByPath(sprintf('[columns][%s]', $fieldName));
        $this->config->offsetUnsetByPath(sprintf('[filters][columns][%s]', $fieldName));
        $this->config->offsetUnsetByPath(sprintf('[sorters][columns][%s]', $fieldName));
    }

    /**
     * @param string $fieldName
     * @param string $label
     */
    private function addColumn(string $fieldName, string $label)
    {
        $this->config->offsetSetByPath(sprintf('[columns][%s]', $fieldName), ['label' => $label]);
    }
}

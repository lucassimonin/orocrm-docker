<?php


namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Oro\Bundle\DashboardBundle\Model\WidgetConfigs;

/**
 * @Route("/custom-widget")
 */
class DashboardController extends Controller
{
    /**
     * @Route(name="hello_word_widget", path="/hello/{widget}")
     * @param $widget
     *
     * @return Response
     */
    public function helloWidgetAction($widget)
    {
        return $this->render(
            'dashboard/hello_widget.html.twig',
            array_merge(
            $this->widgetConfigs()->getWidgetAttributesForTwig($widget),
            ['word' => 'toto']
            )
        );
    }

    /**
     * @return WidgetConfigs
     */
    private function widgetConfigs(): WidgetConfigs
    {
        return $this->get('oro_dashboard.widget_configs');
    }
}

<?php /** @noinspection PhpUnusedParameterInspection */

namespace App\Handler;

use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DebugViewHandler
{
    /**
     * @param ViewHandler $handler
     * @param View $view
     * @param Request $request
     * @param $format
     * @return Response
     */
    public function createResponse(ViewHandler $handler, View $view, Request $request, $format)
    {
        ob_start();
        dump(is_array($view->getData()) ? $view->getData()['data'] : $view->getData());
        $content = ob_get_clean();

        return new Response($content, $view->getStatusCode() ?? 200);
    }
}
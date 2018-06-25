<?php

namespace App\Describer;

use EXSyst\Component\Swagger\Parameter;
use EXSyst\Component\Swagger\Swagger;
use Nelmio\ApiDocBundle\Describer\DescriberInterface;

class SimpleDescriber implements DescriberInterface
{
    /**
     * @param Swagger $api
     */
    public function describe(Swagger $api)
    {
        $paths = $api->getPaths();
        foreach ($paths as $uri => $path) {
            foreach ($path->getMethods() as $method) {
                /** @var Parameter $parameter */
                foreach ($path->getOperation($method)->getParameters() as $parameter) {
                    if ($parameter->getName() === 'version' && $parameter->getDefault() === null) {
                        $parameter->setDefault('v1');
                    }
                }
            }
        }
    }
}
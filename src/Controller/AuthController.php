<?php

namespace App\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Swagger\Annotations as SWG;

class AuthController extends FOSRestController
{

    /**
     * Authenticate with a valid user to get a JWT for later requests.
     *
     * @Rest\Post("/login")
     * @Rest\View()
     *
     * @SWG\Tag(name="Login")
     * @SWG\Parameter(name="credentials", in="body", @SWG\Schema(
     *     type="object",
     *     @SWG\Property(property="_username", type="string"),
     *     @SWG\Property(property="_password", type="string")
     * ))
     * @SWG\Response(
     *     response=200,
     *     description="Token you need to authenticate for later requests",
     *     @SWG\Schema(type="object", @SWG\Property(property="token", type="string"))
     * )
     */
    public function login() {
        //Method only exists so the endpoint appears in the API docs.
    }
}
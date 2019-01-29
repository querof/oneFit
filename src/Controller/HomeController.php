<?php

namespace src\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/*
 * Controller thats contents Home actions.
 */

class HomeController
{

  /**
   * Generate Token.
   *
   * @param Request $request. Instance of request object. with the parameter
   *        "params" in json format with the fields and values filter to make
   *        the search.
   *
   * @return String with Token.
   */

    public function IndexAction(Request $request)
    {
        return new JsonResponse(array('message' => 'This is Home!'));
    }
}

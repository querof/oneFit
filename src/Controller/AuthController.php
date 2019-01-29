<?php

namespace src\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use src\db\orm\model\User;
use src\lib\Auth;

/*
 * Controller thats contents Token AUTH actions
 */

class AuthController
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

    public function SignInAction(Request $request)
    {
        $params = json_decode($request->get('params'), true);
        $params['user']['password']['value']=md5($params['user']['password']['value']);
        $u = new User();
        $u->findBy($params);
        
        if (count($u->getData()) == 0) {
            $response = new Response();
            $response->setContent(json_encode(array('error' => 'Wrong user name or password')));
            $response->setStatusCode(401);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return new JsonResponse(array('token' => Auth::SignIn(['email' => $params['user']['email'],'id' => rand(0, 9999),])));
    }


    /**
     * Check the Token.
     *
     * @param Request $request. Instance of request object. conatints 'token'
     *        parameter, that containts token string.
     * @param Boolean true if token it's valid.
     *
     * @return Json of the query result; according
     *         with resulset of the database.
     */

    public function CheckAction(Request $request)
    {
        return new JsonResponse(array('token' => Auth::Check($request->get('token'))));
    }
}

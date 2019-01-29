<?php

namespace src\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use src\lib\EmailService as Email;
use src\db\orm\model\User;

/*
 * Controller thats contents the main actions of user creation, in order to
 * * get/Update User data.
 *
 */

class UserController
{

  /**
   * Returns JsonResponse with all data of the User entity.
   *
   * @return Json of the query result; according
   *         with resulset of the database.
   */

    public function ListAction(Request $request)
    {
        $u = new User();
        return new JsonResponse($u->findAll($request));
    }


    /**
     * Returns JsonResponse with one record retrived by PK.
     *
     * @param Integer $id. Mandatory parameter contents the Pk value
     *        of the table.
     *
     * @return Json of the query result; according
     *         with resulset of the database.
     */

    public function GetAction($id)
    {
        $u = new User();
        return new JsonResponse($u->findByPk($id));
    }


    /**
     * Returns JsonResponse with all data of the User entity filtered by
     * the parameters.
     *
     * @param Request $request. Instance of request object. with the parameter
     *        "params" in json format with the fields and values filter to make
     *        the search.
     *
     * @return Json of the query result; according
     *         with resulset of the database.
     */

    public function SearchAction(Request $request)
    {
        $params = json_decode($request->get('params'), true)??[];
        $relations = json_decode($request->get('relations'), true)??[];

        $u = new User();
        return new JsonResponse($u->findBy($params, $relations));
    }


    /**
     * Action thats create a new User record.
     *
     * @param Request $request. Instance of request object.
     *
     * @return Json reponse with a message for successfull/unsuccessfull.
     */

    public function CreateAction(Request $request)
    {
        $u = new User();
        $mail = new Email('register');

        $u->name->setValue($request->get('name'));
        $u->lastname->setValue($request->get('lastname'));
        $u->email->setValue($request->get('email'));
        $u->size->setValue($request->get('size'));
        $u->weight->setValue($request->get('weight'));

        $hash = md5($request->get('password'));

        $u->password->setValue($hash??$u->password->getValue());
        $u->save();

        $mail->configEmail($u->id->getValue());
        $emailResponse=$mail->send();

        if ($u->id->getValue()===null || $emailResponse!==true) {
            $response = new Response();
            $msg ='Can\'t create the user';
            if ($emailResponse!==true) {
                $msg = $emailResponse;
                $this->DeleteAction($u->id->getValue());
            }

            $response->setContent(json_encode(array('error' => $msg)));
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return new JsonResponse(array('message' => 'User created, We send you an confirmation email!','id' => $u->id->getValue()
      ));
    }


    /**
     * Action thats update a User record.
     *
     * @param Integer $id. Mandatory parameter contents the Pk value
     *        of the table.
     *
     * @param Request $request. Instance of request object.
     *
     * @return Json reponse with a message for successfull.
     */

    public function UpdateAction($id, Request $request)
    {
        $u = new User();

        $u->findByPk($id);

        $u->name->setValue($request->get('name'));
        $u->lastname->setValue($request->get('lastname'));
        $u->email->setValue($request->get('email'));
        $u->size->setValue($request->get('size'));
        $u->weight->setValue($request->get('weight'));

        $hash = md5($request->get('password'));

        $u->password->setValue($hash);
        $u->save();

        return new JsonResponse(array('message' => 'Email '.$u->email->getValue().' User record updated!','id' => $u->id->getValue()));
    }

    /**
     * Action thats confirm a User.
     *
     * @param Integer $id. Mandatory parameter contents the Pk value
     *        of the table.
     *
     * @param Request $request. Instance of request object.
     *
     * @return Json reponse with a message for successfull.
     */

    public function confirmAction($id, Request $request)
    {
        $u = new User();

        $u->findByPk(urldecode($id));

        $u->confirmed->setValue(true);
        $u->save();

        $response = new Response();
        $response->setContent(json_encode(array('error' => 'User Confirmed!')));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * Action thats delete a User record.
     *
     * @param Integer $id. Mandatory parameter contents the Pk value
     *        of the table.
     *
     * @return Json reponse with a message for successfull.
     */

    public function DeleteAction($id)
    {
        $u = new User();

        $u->findByPk($id);

        $rows = $u->delete();

        if ($rows==1) {
            return new JsonResponse(array('message' => 'Record deleted!'));
        }

        $response = new Response();
        $response->setContent(json_encode(array('error' => 'Can\'t delete the record')));
        $response->setStatusCode(500);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

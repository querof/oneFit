<?php

namespace src\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use src\db\orm\model\Excercises;

/*
 * Controller thats contents the main actions of the API, in order to get/Update Excercises data.
 *
 */

class ExcercisesController
{

  /**
   * Returns JsonResponse with all data of the Excercises entity.
   *
   * @return Json of the query result; according
   *         with resulset of the database.
   */

    public function ListAction(Request $request)
    {
        $r = new Excercises();
        return new JsonResponse($r->findAll($request));
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
        $r = new Excercises();
        return new JsonResponse($r->findByPk($id));
    }


    /**
     * Returns JsonResponse with all data of the Excercises entity filtered by
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

        $r = new Excercises();
        return new JsonResponse($r->findBy($params, $relations));
    }


    /**
     * Action thats create a new Excercises record.
     *
     * @param Request $request. Instance of request object.
     *
     * @return Json reponse with a message for successfull/unsuccessfull.
     */

    public function CreateAction(Request $request)
    {
        $r = new Excercises();

        $r->name->setValue($request->get('name'));
        $r->description->setValue($request->get('description'));
        $r->save();

        if ($r->id->getValue()===null) {
            $response = new Response();
            $response->setContent(json_encode(array('error' => 'Can\'t create the record')));
            $response->setStatusCode(500);
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

        return new JsonResponse(array('message' => 'Excercises record created!','id' => $r->id->getValue()));
    }


    /**
     * Action thats update a Excercises record.
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
        $r = new Excercises();

        $r->findByPk($id);
        $r->name->setValue($request->get('name'));
        $r->description->setValue($request->get('description'));
        $r->save();

        return new JsonResponse(array('message' => 'Record updated','id' => $r->id->getValue()));
    }


    /**
     * Action thats delete a Excercises record.
     *
     * @param Integer $id. Mandatory parameter contents the Pk value
     *        of the table.
     *
     * @return Json reponse with a message for successfull.
     */

    public function DeleteAction($id)
    {
        $r = new Excercises();

        $r->findByPk($id);

        $rows = $r->delete();

        if ($rows==1) {
            return new JsonResponse(array('message' => 'Record successfully deleted'));
        }

        $response = new Response();
        $response->setContent(json_encode(array('error' => 'Can\'t delete the record')));
        $response->setStatusCode(500);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}

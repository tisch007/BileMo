<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Mobilephone;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation as Doc;
use AppBundle\Representation\Mobilephones;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationList;

class MobilephoneController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/api/mobilephones",
     *     name = "app_mobilephones_list"
     * )
     * @Rest\QueryParam(
     *     name="order",
     *     requirements="asc|desc",
     *     default="asc",
     *     description="Sort order (asc or desc)"
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="\d+",
     *     default="20",
     *     description="Max number of movies per page."
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="\d+",
     *     default="1",
     *     description="The pagination offset"
     * )
     * @Rest\View
     * @Doc\ApiDoc(
     *     section="Mobilephone",
     *     resource=true,
     *     description="Get the list of all articles."
     * )
     */
    public function ShowListAction(ParamFetcherInterface $paramFetcher)
    {
        $pager = $this->getDoctrine()->getRepository('AppBundle:Mobilephone')->search(
            $paramFetcher->get('order'),
            $paramFetcher->get('limit'),
            $paramFetcher->get('page')
        );

        return new Mobilephones($pager);
    }

    /**
     * @Rest\Get(
     *     path = "/api/mobilephones/{id}",
     *     name = "app_mobilephone_show",
     *     requirements = {"id"="\d+"}
     * )
     * @Rest\View
     * @Doc\ApiDoc(
     *     section="Mobilephone",
     *     resource=true,
     *     description="Get one article.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirements"="\d+",
     *             "description"="The article unique identifier."
     *         }
     *     }
     * )
     */
    public function ShowAction($id)
    {
        $mobilephone = $this->getDoctrine()->getManager()->getRepository('AppBundle:Mobilephone')->find($id);
        if(empty($mobilephone)){
            return View::create(['message' => 'Mobilephone not found'], Response::HTTP_NOT_FOUND);
        }

        return $mobilephone;
    }

    /**
     * @Rest\Post(
     *    path = "/mobilephones",
     *    name = "app_mobilephone_post"
     * )
     * @Rest\View(StatusCode=201)
     * @ParamConverter("mobilephone", converter="fos_rest.request_body")
     */

    /*
    public function createAction(Mobilephone $mobilephone, ConstraintViolationList $violations)
    {
        if (count($violations)) {
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }


        $em = $this->getDoctrine()->getManager();
        $em->persist($mobilephone);
        $em->flush();

        return $mobilephone;
    }
    */
}

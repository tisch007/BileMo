<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\View\View;
use JMS\Serializer\SerializationContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation as Doc;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MobilephoneController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/api/mobilephones",
     *     name = "app_mobilephones_list"
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
     *     description="Get the list of all articles.",
     *     output={
     *         "class"="AppBundle\Entity\Mobilephone",
     *         "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *     },
     * )
     */
    public function showListAction(ParamFetcherInterface $paramFetcher, Request $request)
    {
        $limit = $paramFetcher->get('limit');
        $page = $paramFetcher->get('page');

        $em = $this->getDoctrine()->getManager();
        $mobile_list = $em->getRepository("AppBundle:Mobilephone")->findAll();

        $pager = $this->get('knp_paginator');
        $pagination = $pager->paginate($mobile_list,$request->query->getInt('page',$page), $request->query->getInt('limit', $limit));

        $serializer = $this->get('jms_serializer');
        $result = array(
            'data' => $pagination->getItems(),
            'meta' => $pagination->getPaginationData());

        return new Response(
            $serializer->serialize(
                $result,
                'json',
                SerializationContext::create()->setGroups(['Default'])
            ),
            Response::HTTP_OK,
            ['Content-Type' => 'application/json',]
        );
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
     *     {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The mobilephone unique identifier"
     *          }
     *     },
     *     output={
     *         "class"="AppBundle\Entity\Mobilephone",
     *         "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *     },
     * )
     */
    public function showAction($id)
    {
        $mobilephone = $this->getDoctrine()->getManager()->getRepository('AppBundle:Mobilephone')->find($id);
        if (empty($mobilephone)) {
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

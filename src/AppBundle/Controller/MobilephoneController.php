<?php

namespace AppBundle\Controller;


use AppBundle\Entity\Mobilephone;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Nelmio\ApiDocBundle\Annotation as Doc;

class MobilephoneController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path = "/mobilephones",
     *     name = "app_mobilephones_list"
     * )
     * @Rest\View
     * @Doc\ApiDoc(
     *     section="Mobilephone",
     *     resource=true,
     *     description="Get the list of all articles."
     * )
     */
    public function ShowListAction()
    {
        $mobilephones = $this->getDoctrine()->getRepository('AppBundle:Mobilephone')->findAll();

        return $mobilephones;
    }

    /**
     * @Rest\Get(
     *     path = "/mobilephones/{id}",
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
    public function ShowAction(Mobilephone $mobilephone)
    {
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
}

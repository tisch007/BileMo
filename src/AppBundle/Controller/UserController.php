<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class UserController extends Controller
{
    /**
     *@Rest\Get(
     *     path = "/api/clients",
     *     name = "app_client_list"
     * )
     * @ApiDoc(
     *     description="Get the list of all users.",
     *     section="User",
     *     resource=true,
     *     output={
     *         "class"="AppBundle\Entity\User",
     *         "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *     },
     * )
     * @Rest\View
     */
    public function getUsersAction(){
        $users = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->findAll();
//pagination a mettre en place
        return $users;
    }

    /**
     *@Rest\Get(
     *     path = "/api/clients/{id}",
     *     name = "app_client_show",
     *     requirements = {"id"="\d+"}
     * )
     * @ApiDoc(
     *     description="Get one user.",
     *     section="User",
     *     resource=true,
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The user unique identifier"
     *          }
     *     },
     *     output={
     *         "class"="AppBundle\Entity\User",
     *         "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *     },
     * )
     * @Rest\View
     */
    public function getUserAction($id){
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find($id);

        if(empty($user)){
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\Post(
     *    path = "/api/clients",
     *    name = "app_client_post"
     * )
     * @ApiDoc(
     *     description="Création d'un utilisateur",
     *     section="User",
     *     resource=true,
     *     input={
     *         "class"="FOS\UserBundle\Form\Type\RegistrationFormType",
     *         "name"=""
     *     },
     *     statusCodes={
     *         201="Returned when the user is created",
     *         400="Returned when error in the payload"
     *     },
     * )
     * @Rest\View()
     */
    public function postUsersAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');

        $email = $request->request->get('email');
        $username = $request->request->get('username');
        $password = $request->request->get('password');

        if(empty($email) || empty($username) || empty($password)){
            return View::create(['message' => 'Bad request'], Response::HTTP_BAD_REQUEST);
        }

        $email_exist = $userManager->findUserByEmail($email);
        $username_exist = $userManager->findUserByUsername($username);
        if($email_exist || $username_exist){
            $response = new JsonResponse();
            $response->setData("Username/Email ".$username."/".$email." already exists");
            return $response;
        }

        $user = $userManager->createUser();
        $user->setUsername($username);
        $user->setEmail($email);
        $user->setEnabled(true);
        $user->setPlainPassword($password);
        $userManager->updateUser($user, true);

        $response = new JsonResponse();
        $response->setData("User: ".$user->getUsername()." was created");
        return $response;
    }

    /**
     *@Rest\Get(
     *     path = "/api/clients/delete/{id}",
     *     name = "app_client_delete",
     *     requirements = {"id"="\d+"}
     * )
     * @ApiDoc(
     *     description="Delete one user.",
     *     section="User",
     *     resource=true,
     *     requirements={
     *          {
     *              "name"="id",
     *              "dataType"="integer",
     *              "requirement"="\d+",
     *              "description"="The user unique identifier"
     *          }
     *     },
     *     output={
     *         "class"="AppBundle\Entity\User",
     *         "parsers"={"Nelmio\ApiDocBundle\Parser\JmsMetadataParser"}
     *     },
     * )
     * @Rest\View
     */
    public function deleteUsersAction($id)
    {
        $user = $this->getDoctrine()->getManager()->getRepository('AppBundle:User')->find($id);

        if(empty($user)){
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        $response = new JsonResponse();
        $response->setData("User with id " . $id . " was deleted");
        return $response;
    }
}

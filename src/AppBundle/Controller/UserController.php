<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Request\ParamFetcherInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use JMS\Serializer\SerializationContext;

class UserController extends Controller
{
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
}

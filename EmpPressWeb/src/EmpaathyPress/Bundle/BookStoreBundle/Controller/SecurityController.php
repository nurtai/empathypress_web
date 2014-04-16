<?php
/**
 * Created by PhpStorm.
 * User: nurtai
 * Date: 4/9/14 AD
 * Time: 2:20 PM
 */

namespace EmpaathyPress\Bundle\BookStoreBundle\Controller;

use EmpaathyPress\Bundle\BookStoreBundle\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        $request = $this->getRequest();
        $session = $request->getSession();

        // get the login error if there is one
        if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
        } else {
            $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
        }

        return array(
            // last username entered by the user
            'last_username' => $session->get(SecurityContext::LAST_USERNAME),
            'error' => $error,
        );
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

    }

    /**
     * @Route("/register", name="register")
     * @Template()
     *
     */
    public function registerAction(Request $request)
    {
        $factory = $this->container->get('security.encoder_factory');
        $manager = $this->getDoctrine()->getManager();
        if ($request->isMethod('PUT')) {
            return array();
        } else {
            $password = $request->get("password");
            $email = $request->get("email");
            $username = $request->get("username");
            $role = "ROLE_USER";
            $password_confirm = $request->get("password_confirm");
            if ($password != $password_confirm) {
                return array("error" => "Register error");
            }
            $register = new User();
            $register->setEmail($email);
            $register->setUsername($username);
            $encoder = $factory->getEncoder($register);
            $register->setPasswordForIphone(md5($password));
            $password = $encoder->encodePassword($password, $register->getSalt());
            $register->setPassword($password);


            $role_obj = $manager->getRepository("EmpaathyPressBookStoreBundle:Role")->findOneBy(array("name" => $role));
            $register->addRole($role_obj);
            $manager->persist($register);

            try {
                $manager->flush();
            } catch (\Exception $e) {
                if ($e->getCode() == 0) {
                    return array("error" => "This Information already registered!");
                }

            }
            return $this->redirect($this->generateUrl('home'));
        }

    }

    /**
     * @Route("/login_iphone", name="login_iphone")
     * @Template()
     *
     */
    public function loginIPhoneAction(Request $request)
    {
        $data = array();
        $username = $request->get("username");
        $password = $request->get("password");
        error_log("Username: ".$username);
        error_log("Password: ".$password);
        $manager = $this->getDoctrine()->getManager();
        $role_obj = $manager->getRepository("EmpaathyPressBookStoreBundle:User")->findOneBy(array("username" => $username, "password_for_iphone" => md5($password)));
        /* @var $role_obj User */
        if ($role_obj) {
            $data["id"] = $role_obj->getId();
            $data["username"] = $role_obj->getUsername();
            $data["password"] = $role_obj->getPasswordForIphone();
        }
        $response = new JsonResponse();
        $response->setContent(json_encode($data, JSON_UNESCAPED_UNICODE));
        $response->headers->set('Content-Type', 'application/json; charset=utf-8');

        return $response;

    }
}

?>
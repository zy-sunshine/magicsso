<?php
namespace MagicSSO\Bundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;

use MagicSSO\Bundle\Entity\User;
use MagicSSO\Bundle\Entity\Profile;


class RpcController extends Controller
{
    /**
     * @Secure(roles="ROLE_USER")
     */
    public function testAction()
    {
    	return new Response("RpcController::testAction");
    }
    public function checkTgtAction()
    {
        $request = $this->container->get('request');

        // Make sure user has login on magicsso.
        $user = $this->container->get('security.context')->getToken()->getUser();
        if (!is_object($user) || !$user instanceof User) {
            return $this->redirect($this->generateUrl('sso_security_login', array('url' => $request->getUri())));
        }

        // check the tgt is legal or not.
        $tgt = $request->get('tgt');
        // var_dump($user->profile->tgt);
        die('');
        $content = '';
        if(empty($tgt)){
            $content = 'nothing...';
        }

        

        // return $this->renderJson();
    	return $this->render('MagicSSOBundle:Test:index.html.twig', array('content' => $content));
    }
    private function renderJson($arr = array('data' => 123)){
        $response = new JsonResponse();
        $response->setData($arr);
        return $response;
    }
}
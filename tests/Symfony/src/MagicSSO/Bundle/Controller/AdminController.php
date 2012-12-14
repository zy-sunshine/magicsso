<?php
namespace MagicSSO\Bundle\Controller;

use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;

use MagicSSO\Bundle\Entity\User;
use MagicSSO\Bundle\Entity\Profile;


class AdminController extends Controller
{
    /**
     * //@Secure(roles="ROLE_USER")
     */
    public function indexAction()
    {
    	return $this->render('MagicSSOBundle:Admin:index.html.twig');
    }
    public function repairuserAction()
    {
    	return $this->render('MagicSSOBundle:Admin:repairuser.html.twig');
    }
}
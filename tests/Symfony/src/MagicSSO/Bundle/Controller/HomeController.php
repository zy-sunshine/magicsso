<?php

namespace MagicSSO\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */

        $SITE = array('TITLE' => 'TestTitle');
        return $this->render('MagicSSOBundle:Home:index.html.twig', array('SITE' => $SITE, 'content' => $this->container->getParameter('magicsso.email.from')));
        //'content' => $container->getParameter('acme_hello.email.from')
    }
    public function sendVerifyEmail()
    {
        $verify_code = "123456";

        // $message = \Swift_Message::newInstance()
        //     ->setSubject('Hello Email')
        //     ->setFrom('magiclinuxgroup@gmail.com')
        //     ->setTo('zy.netsec@gmail.com')
        //     ->setBody($this->renderView('MagicSSOBundle:Email:register_verify.txt.twig', array('verify_code' => $verify_code)));
        // $this->get('mailer')->send($message);

        // Custom mailer...
        // $mailer = $this->get('my_mailer');
        // $mailer->send('ryan@foobar.net');
    }
}

use Symfony\Component\Templating\EngineInterface;

class NewsletterManager
{
    protected $mailer;

    protected $templating;

    public function __construct( $mailer)
    {
        $this->mailer = $mailer;
        // $this->templating = $templating;
    }

    // ...
}
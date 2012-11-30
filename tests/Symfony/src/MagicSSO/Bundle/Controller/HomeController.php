<?php

namespace MagicSSO\Bundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use MagicSSO\Bundle\Entity\User;
use MagicSSO\Bundle\Entity\Category;

use Symfony\Bundle\FrameworkBundle\Templating\GlobalVariables;

class HomeController extends Controller
{
    public function indexAction()
    {
        /*
         * The action's view can be rendered using render() method
         * or @Template annotation as demonstrated in DemoController.
         *
         */
        $content = $this->container->getParameter('magicsso.email.from');

        // $conn = $this->get('database_connection');
        // $users = $conn->fetchAll('SELECT * FROM test');
        // $content = var_dump($users);

        $user = $this->_queryUser(1);
        // $user = $this->_changePw("test username", "new password");

        // $user = $this->_delUser(4);
        $users = $this->__getRepo()->findAllUserByEmail("test email");
        //var_dump($users);

        $SITE = array('TITLE' => 'TestTitle');
        // return $this->render('MagicSSOBundle:Home:index.html.twig', array('SITE' => $SITE, 
        //     'content' => $content));
        return new Response('Created user id '.$user->getId().' name '.$user->getUn().' email '.$user->getEmail().' password '.$user->getPw());
    }
    public function categoryAction(){
        $this->addCategory();
        return new Response("categoryAction page");
    }
    public function admintestAction(){
        $g = new GlobalVariables($this->container);
        $user = $g->getUser();
        $un = $user->getUsername();
        $pw = $user->getPassword();
        $email = $user->getEmail();
        // Or use <p>Username: {{ app.user.username }}</p>
        return new Response("admintestAction page username:".$un." password:".$pw." email:".$email);
    }
    public function addCategory(){
        $category = new Category();
        $category->setName('Anonymous Group');

        $user = $this->__getUserById(1);
        // relate this user to the category
        $user->setCategory($category);

        $em = $this->getDoctrine()->getManager();
        $em->persist($category);
        $em->flush();
    }

    /*
     *  User Table
     */
    private function _addUser(){
        $user = new User();
        $user->setUn("test username");
        $user->setPw("test password");
        $user->setEmail("test email");

        var_dump($user->getUn());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

    }
    private function _queryUser($id){
        return $this->__getUserById($id);
    }
    private function _changePw($un, $newpw){
        $em = $this->__getEm();
        $user = $this->__getUserByName($un);
        $user->setPw($newpw);
        $em->flush();
        return $user;
    }
    private function __getUserById($id){
        $user = $this->__getRepo()->find($id);
        if (!$user) {
            throw $this->createNotFoundException('No user found for username '.$un);
        }
        return $user;
    }
    private function __getUserByName($un){
        $user = $this->__getRepo()->findOneByUn($un);
        if (!$user) {
            throw $this->createNotFoundException('No user found for username '.$un);
        }
        return $user;
    }
    private function __getRepo(){
        return $this->getDoctrine()->getManager()->getRepository('MagicSSOBundle:User');
    }
    private function __getEm(){
        return $this->getDoctrine()->getManager();
    }
    private function _delUser($id){
        $user = $this->__getUserById($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
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
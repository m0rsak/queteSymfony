<?php
/**
 * Created by PhpStorm.
 * User: m0rsak
 * Date: 16/05/18
 * Time: 17:41
 */


namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;


/**
 * Class ReviewController
 * @package AppBundle\Controller
 *
 * @route("review")
 */

Class ReviewController extends Controller
{
    /**
     * @Route("/", methods={"GET","POST"})
     *
     *
     */
    public function indexAction()
    {
        return $this->render('review/index.html.twig');
    }

    /**
     * @Route("/new")
     * @Method("GET")
     *
     */
    public function newAction()
    {
        return $this->render('review/new.html.twig');
    }
}


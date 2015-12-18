<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 18/12/15
 * Time: 10:17
 */

namespace AK\BlogBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class ArticlesController extends Controller
{
    /**
     * @Route("/list")
     * @Template("AKBlogBundle:Articles:list.html.twig")
     */
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('AKBlogBundle:Post')->findBy(array());

        return [
            "posts" => $posts
        ];
    }

}
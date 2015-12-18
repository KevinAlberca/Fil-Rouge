<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 18/12/15
 * Time: 10:17
 */

namespace AK\BlogBundle\Controller;

use AK\BlogBundle\Entity\Post;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;



class ArticlesController extends Controller
{
  /**
  * @Route("/create")
  * @Template("AKBlogBundle:Articles:create.html.twig")
  */
  public function createAction(Request $request)
  {
    $post = new Post();

    $form = $this->createFormBuilder($post)
      ->add("title", "text")
      ->add("body", "textarea")
      ->add("submit", "submit")
      ->getForm();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
      $em = $this->get('doctrine.orm.default_entity_manager');
      $post->setIsPublished(false);
      $em->persist($post);
      $em->flush();
    }

    return [
      "form" => $form->createView()
    ];
  }

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

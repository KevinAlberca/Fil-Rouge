<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 18/12/15
 * Time: 10:17
 */

namespace AK\BlogBundle\Controller;

use AK\BlogBundle\Entity\Post;
use AK\BlogBundle\Entity\PostRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



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

    /**
    * @Route("/search")
    * @Template("AKBlogBundle:Articles:search.html.twig")
    **/
    public function searchAction(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add("search", "text")
            ->add("is_published", "checkbox", array(
                "required" => false
            ))
            ->add("submit", "submit")
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $title = $form->getData()["search"];
            $is_published = $form->getData()["is_published"];

            $em = $this->getDoctrine()->getManager();
            $posts = $em->getRepository("AKBlogBundle:Post")->search($title, $is_published);

            return [
                "posts" => $posts,
                "form" => $form->createView()
            ];
        }

        return [
            "form" => $form->createView(),
            "posts" => null,
        ];

    }

}

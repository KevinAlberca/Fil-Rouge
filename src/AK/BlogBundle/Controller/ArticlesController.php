<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 18/12/15
 * Time: 10:17
 */

namespace AK\BlogBundle\Controller;

use AK\BlogBundle\Entity\Post;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Pagerfanta;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\View\DefaultView;
use Pagerfanta\Exception\NotValidCurrentPageException;
use Symfony\Component\HttpKernel\Exception\HttpException;


class ArticlesController extends Controller
{
    /**
     * @Route("/propose")
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
     * @Route("/", name="homepage_list")
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
    * @Route("/search/{id}", defaults={"id" = 1}, name="blog_search")
    * @Template("AKBlogBundle:Articles:search.html.twig")
    **/
    public function searchAction(Request $request, $id)
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

            $adapter = new ArrayAdapter($posts);

            $pager = new Pagerfanta($adapter, false);
            $pager->setCurrentPage($id);

            $pager->hasPreviousPage() ? $pager->getPreviousPage(): null;
            $pager->hasNextPage() ? $pager->getNextPage() : null;

            return [
                "posts" => $pager,
                "form" => $form->createView(),
                "search" => $title,
            ];
        }

        return [
            "form" => $form->createView(),
            "posts" => null,
        ];

    }

}

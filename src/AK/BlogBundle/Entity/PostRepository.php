<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 11/12/15
 * Time: 10:50
 */

namespace AK\BlogBundle\Entity;


use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{

    public function findAll()
    {
        return $this->getEntityManager()->createQueryBuilder()
            ->add("select", "*")
            ->add("from", "post")
//            ->add("where", "p.is_published = :published")
//            ->add("orderBy", "p.created_at DESC")
//            ->setParameter("published", true)
            ->getQuery()
            ->getResult();
    }

    public function search($search, $published)
    {

        $req = $this->getEntityManager()->createQueryBuilder()
            ->select("p")
            ->from("AKBlogBundle:Post", "p")
            ->where("p.title LIKE :search")
                ->setParameter("search", "%".$search."%")
            ->orWhere("p.body LIKE :search")
                ->setParameter("search", "%".$search."%");

            if($published === true){
            $req->andWhere("p.isPublished = :published")
                ->setParameter("published", $published);
            }

        return $req->getQuery()->getResult();
    }

}
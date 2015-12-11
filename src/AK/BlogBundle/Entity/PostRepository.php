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
            ->add("select", "p")
            ->add("from", "Post p")
            ->add("where", "p.is_published = :published")
            ->add("orderBy", "p.created_at DESC")
            ->setParameter("published", true)
            ->getQuery()
            ->getResult();
    }

}
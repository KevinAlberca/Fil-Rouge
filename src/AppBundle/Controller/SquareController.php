<?php
/**
 * Created by PhpStorm.
 * User: AwH
 * Date: 30/11/15
 * Time: 09:49
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SquareController extends Controller
{

    public function squareNumberAction($number)
    {
        $square = $number * $number;
        return new Response("<span style='color:red; font-weight:700;'>".$square."</span>");
    }

}
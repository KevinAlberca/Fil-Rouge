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


class TimeController extends Controller
{
    /**
     * @Route("/current-time")
     */
    public function currentTimeAction()
    {
        $time = date("d M Y H:i:s");
        return new Response("<span style='color:red; font-weight:700;'>".$time."</span>");
    }

}
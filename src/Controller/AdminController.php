<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 */
class AdminController extends BaseController
{
   /**
     * @Route("/", name="wassa_admin", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    } 
   
    /**
     * 
     * @Route("/wassa-users",name="wassa_users", methods={"GET"})
     */
    public function manage_users(): Response
    {
        return $this->render("admin/index.html.twig");
    }
}

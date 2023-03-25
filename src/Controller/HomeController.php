<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\WassaContact;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\WassaContactType;
use Exception;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }


    #[Route('/contact', name:('wassa_contact'), methods:["GET", "POST"])]
    public function contact(Request $request, MailerInterface $mailer, EntityManagerInterface $entityManager): Response
    {
        $contact = new WassaContact();
        $form = $this->createForm(WassaContactType::class, $contact);
        $form->handleRequest($request);
        $confirmSent = false;
        if ($form->isSubmitted() && $form->isValid()) {
            
            $contact = $form->getData();
            $contact->setSendDate(new \DateTime());

            $entityManager->persist($contact);
            $entityManager->flush();

            try {

                $email = (new TemplatedEmail())
                    ->from('contact@wassa-boutique.com')
                    ->to(new Address('alassane.traore@wassa-boutique.com'))
                    ->cc(new Address('alas_sane@hotmail.fr'))
                    ->subject('Contact-Wassa-Boutique')
                    ->htmlTemplate("emails/contact.html.twig")
                    ->context([
                        'sender' => $contact->getName() . '[' . $contact->getEmail() . ']',
                        'message' => $contact->getMessage(),
                        'subject' => $contact->getSubject(),
                        'user_phone' => $contact->getPhone()
                    ]);

                $mailer->send($email);
                $confirmSent = true;
            } catch (Exception $ex) {
                $confirmSent = false;
                //log exception
            }
        }
        return $this->render('home/contact.html.twig', [
            'wassa_contact' => $contact,
            'form' => $form->createView(),
            'confirm_sent' => $confirmSent
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {   
        
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }



    #[Route('/nos-products', name: 'wassa_products',  methods: ['GET'])]
    public function product(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('home/all_products.html.twig', [
            'allProducts' => array_chunk($products, 3)
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;


#[Route('/product')]
class ProductController extends BaseController
{
    #[Route('/', name: 'app_product_index', methods: ['GET'])]
    public function index(ProductRepository $productRepository): Response
    {
        $reflectionExtractor = new ReflectionExtractor();

        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_product_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProductRepository $productRepository): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
             //get the current date
             $product->setAddedDate(new \DateTime());
             $errors_list = array();
             $destinationDir = $this->getParameter('products_img_directory');
             $product->setProductImages($destinationDir, $form, $errors_list);

            $productRepository->save($product, true);
            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/new.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_show', methods: ['GET'])]
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_product_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $errors_list = array();
            $destinationDir = $this->getParameter('products_img_directory');
            
            $product->setProductImages($destinationDir, $form, $errors_list);
            $product->setUpdatedDate(new \DateTime());
            $productRepository->save($product, true);

            return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('product/edit.html.twig', [
            'product' => $product,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_product_delete', methods: ['POST'])]
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('app_product_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route("/download-file", name:"download_product_img", methods: ["post"])]
    public function downloadFile(Request $request):Response
    {
        $fileName = $request->request->get('fileName');
       
        $filesystem = new Filesystem();
        
        if ($request->isXMLHttpRequest()) {  
            $products_img_dir = $this->getParameter('products_img_directory');
            
            $pathToFile = $products_img_dir.'/'.$fileName;
            $pathToImg = "";
            $alt = "";
            $errorMessage = "";
            
            if($filesystem->exists($pathToFile)){
                $pathToImg = "/images/products/$fileName";
                $alt = "wassa-boutique-image-preview";
            }
            else{
                $errorMessage = "Aucune image trouvée à l'emplacement suivant";
            }
            
            $content = $this->renderView('image/preview.html.twig',[
                                        "pathToImg"=>$pathToImg,
                                        "alt"=>$alt,
                                        "errorMessage" => $errorMessage
                                    ]);
            
            return new Response($content);
        }
        
        return new Response("Une erreur de requête s'est produite", 400);
    }
    
    #[Route("/delete-file", name:"delete_product_image", methods: ["Post"])] 
    public function deleteFile(Request $request):Response
    {
        $productId = $request->request->get('eltId');
        $fileName = $request->request->get('fileName');
        $pictureNumber = $request->request->get('pictureNumber');
        
        $entityManager = $this->getManager();
        $currentProduct = $entityManager->getRepository(Product::class)->find($productId);
        
        $filesystem = new Filesystem();
        
        $products_img_dir = $this->getParameter('products_img_directory');
        $pathToFile = $products_img_dir.DIRECTORY_SEPARATOR.$fileName;
        
        if ($request->isXMLHttpRequest() && $currentProduct != null) {
            if($filesystem->exists($pathToFile)){
                
                //reset corresponding image property value
                if ($pictureNumber == 1){
                    $currentProduct->setPicture1(null);
                }
                else if($pictureNumber == 2){
                    $currentProduct->setPicture2(null);
                }
                else if($pictureNumber == 3){
                    $currentProduct->setPicture3(null);
                }
                else if($pictureNumber == 4){
                    $currentProduct->setPicture4(null);
                }
                
                $currentProduct->setUpdatedDate(new \DateTime());
                $entityManager->flush();
                $filesystem->remove($pathToFile);

                if(!$filesystem->exists($pathToFile)){
                    return $this->json(['status' => true,'message'=>"le fichier a été supprimé avec succès."]);
                }
                else{
                    return $this->json(['status' => false,'message'=>"le fichier n'a pu être supprimé."]);
                }
            }
            else{
                return $this->json(['status' => false,'mesage'=>"Impossible de trouver le fichier : ".$pathToFile]);
            }
        }
        return new Response("Une erreur de requête s'est produite", 400);
    }
}

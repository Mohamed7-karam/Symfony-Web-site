<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\CategoriesServices;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
    }
    #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        $form = $this->createFormBuilder()
                     ->add("Email", EmailType::class, [
                        "label" => "Votre Email:",
                        "attr" =>[
                            "placeholder" => "Votre email Svp ...",
                            "class" =>"form-group"
                        ],
                        "row_attr" =>[
                            "class" =>"form_group"
                        ]
                     ])
                     ->add("Subject", TextType::class, [
                        "label" => "Votre Objet:",
                        "attr" =>[
                            "placeholder" => "Votre Subject Svp ...",
                            "class" =>"form-group"
                        ],
                        "row_attr" =>[
                            "class" =>"form_group"
                        ]
                     ])
                     ->add("Message", TextareaType::class,[
                        "label" => "Votre Message:",
                        "attr" =>[
                            "placeholder" => "Votre Message Svp ...",
                            "class" =>"form-group"
                        ],
                        "row_attr" =>[
                            "class" =>"form_group"
                        ]
                     ])
                     ->getForm()

        ;
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $form->createView()
        ]);
    }
}

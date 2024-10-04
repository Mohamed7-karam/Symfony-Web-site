<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Category;
use App\Form\ContactType;
use App\Services\CategoriesServices;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\WeekType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// https://symfony.com/doc/current/reference/forms/types.html
class ContactController extends AbstractController
{
    public function __construct(CategoriesServices $categoriesServices){
        $categoriesServices->updateSession();
    }
    
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request,CategoryRepository $repoCat, EntityManagerInterface $em): Response
    {

        $contact = new Contact();
        $form =  $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        $session = $request->getSession();

        if($form->isSubmitted() && $form->isValid()){
            $contact->setCreatedAt(new \DateTimeImmutable());
            $em->persist($contact);
            $em->flush();
            $contact = new Contact();
            $form =  $this->createForm(ContactType::class, $contact); 

            
            $session->getFlashBag()->add("message", "Message sent successfully");
            $session->set('status', "success");
            
        }else if($form->isSubmitted() && ! $form->isValid()){
            $session->getFlashBag()->add("message", "Please correct the errors");
            $session->set('status', "danger");

        }
       

        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $form->createView()
        ]);
    }
 
}

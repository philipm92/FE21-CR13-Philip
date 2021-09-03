<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\NumberType; ///?????
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
// use Symfony\Component\Form\Extension\Core\Type\ResetType;
// use Symfony\Component\Form\ClickableInterface;
// use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\File\Exception\FileException; ///?????
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Events;
use App\Entity\Type;

class EventsController extends AbstractController
{
    #[Route('/events', name: 'events')]
    public function index(Request $request): Response
    {
        // do filter button
        $form = $this->createFormBuilder()
        ->add("Categories", EntityType::class, array('attr'=>array("class"=>"form-control my-2"), 'class'=>Type::class, 'choice_label'=>'name'))
        // ->add('reset', SubmitType::class, array('label'=> 'Show All', 'attr' => array('class'=> 'btn btn-secondary m-2')))
        ->add('filter', SubmitType::class, array('label'=> 'Filter Events', 'attr' => array('class'=> 'btn btn-primary m-2')))
        ->getForm();
        $form->handleRequest($request);
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository('App:Events');
        $events = $repository->findAll();

        // change what is stored in events based on if the filter-button is clicked
        if($form->isSubmitted() && $form->isValid()) {
            $category_id = $form["Categories"]->getData()->getId();
            $events = $repository->findBy(array("fk_events" => $category_id));
            $this->addFlash(
                'notice',
                'Events Filtered'
            );        
            // another condition to get the right button
            // $form->get("filter")->isClicked() NOT RECOGNIZED WHY????
            // if ($form ) {
            //     $events = $repository->findBy(array("fk_events" => $category_id));
            //     $this->addFlash(
            //         'notice',
            //         'Events Filtered'
            //     );
            // }
            // if ($form->get('reset')->isClicked()) {
            //     $events = $repository->findAll();
            //     $this->addFlash(
            //         'notice',
            //         'Show All Events'
            //     );
            // }            
        }


        // try getting column names
        // $mappings = $doctrine->getManager()->getClassMetadata('App:Events');
        // $fieldnames = $mappings->getFieldNames();
        // dd($fieldNames);        

        return $this->render('events/index.html.twig', array('events'=>$events, 'form' => $form->createView()));
    }

    #[Route("/events/create", name:"events_create")]
    public function create(Request $request,SluggerInterface $slugger): Response
    {
        // `fk_events_id`, `name`, `date`, `description`, `image`, `capacity`, `email`, `phone`, `address`, `url`
        // Here we create an object from the class that we made
        $events = new events;
        //* Here we will build a form using createFormBuilder and inside this function we will put our object and then we write add then we select the input type then an array to add an attribute that we want in our input field */
        $form = $this->createFormBuilder($events)->add('name', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('name', TextType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('date', DateTimeType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('capacity', NumberType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('email', EmailType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('phone', TelType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('address', TextType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('url', UrlType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add("fk_events", EntityType::class, array('attr'=>array("class"=>"form-control my-1"), 'class'=>Type::class, 'choice_label'=>'name'))
        ->add("image", FileType::class, array('attr'=>array("class"=>"form-control my-1"),'label' => 'Image (png/jpg file)','mapped' => false,'required' => true,'constraints' => [
            new File([
                'maxSize' => '4096k',
                'mimeTypes' => [
                    'image/*'                
                ],
                'mimeTypesMessage' => 'Please upload a valid image document',
            ])
        ]))
        ->add('save', SubmitType::class, array('label'=> 'Add event', 'attr' => array('class'=> 'btn-primary')))
        ->getForm();
        $form->handleRequest($request);

        /* Here we have an if statement, if we click submit and if  the form is valid we will take the values from the form and we will save them in the new variables */
        if($form->isSubmitted() && $form->isValid()){
            //fetching data
            // taking the data from the inputs by the name of the inputs then getData() function
            $name = $form['name']->getData();
            $date = $form['date']->getData();
            $description = $form['description']->getData();
            $email = $form['email']->getData();
            $phone = $form['phone']->getData();
            $address = $form['address']->getData();
            $url = $form['url']->getData();
            $fk_events = $form['fk_events']->getData();
            $image = $form["image"]->getData();
            if ($image) {
                // $image = ($image === NULL) ? "animal.png" : $image;
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $events->setImage($newFilename);
            } 
            // else $events->setImage($newFilename); 
            // animal.png           

            /* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
            $events->setName($name);
            $events->setDate($date);
            $events->setDescription($description);
            $events->setEmail($email);
            $events->setPhone($phone);
            $events->setAddress($address);
            $events->setUrl($url);
            $events->setFkEvents($fk_events);
            $em = $this->getDoctrine()->getManager();
            $em->persist($events);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Event Added'
            );
            return $this->redirectToRoute('events');
        }

        /* now to make the form we will add this line form->createView() and now you can see the form in create.html.twig file  */
        return $this->render('events/create.html.twig', array('form' => $form->createView()));
    }


    #[Route("/events/edit/{id}", name:"events_edit")]
    public function edit(Request $request, SluggerInterface $slugger, $id): Response
    {
        // Here we create an object from the class that we made
        $event = $this->getDoctrine()->getRepository('App:Events')->find($id);
        
        //* Here we will build a form using createFormBuilder and inside this function we will put our object and then we write add then we select the input type then an array to add an attribute that we want in our input field */
        $form = $this->createFormBuilder($event)->add('name', TextType::class, array('attr' => array('class'=> 'form-control')))
        ->add('name', TextType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('date', DateTimeType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('description', TextareaType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('capacity', NumberType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('email', EmailType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('phone', TelType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('address', TextType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add('url', UrlType::class, array('attr' => array('class'=> 'form-control my-1')))
        ->add("fk_events", EntityType::class, array('attr'=>array("class"=>"form-control my-1"), 'class'=>Type::class, 'choice_label'=>'name'))
        ->add("image", FileType::class, array('attr'=>array("class"=>"form-control my-2"),'label' => 'Image (png/jpg file)','mapped' => false,'required' => FALSE,'constraints' => [
            new File([
                'maxSize' => '4096k',
                'mimeTypes' => [
                    'image/*'                
                ],
                'mimeTypesMessage' => 'Please upload a valid image document',
            ])
        ]))
        ->add('save', SubmitType::class, array('label'=> "Edit ".$event->name, 'attr' => array('class'=> 'btn-secondary')))
        ->getForm();
        $form->handleRequest($request);

        /* Here we have an if statement, if we click submit and if  the form is valid we will take the values from the form and we will save them in the new variables */
        if($form->isSubmitted() && $form->isValid()){
            //fetching data
            // taking the data from the inputs by the name of the inputs then getData() function
            $name = $form['name']->getData();
            $date = $form['date']->getData();
            $description = $form['description']->getData();
            $email = $form['email']->getData();
            $phone = $form['phone']->getData();
            $address = $form['address']->getData();
            $url = $form['url']->getData();
            $fk_events = $form['fk_events']->getData();
            $image = $form["image"]->getData();
            if ($image) {
                // $image = ($image === NULL) ? "animal.png" : $image;
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$image->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $image->move(
                        $this->getParameter('image_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $event->setImage($newFilename);
            }         

            /* these functions we bring from our entities, every column have a set function and we put the value that we get from the form */
            $event->setName($name);
            $event->setDate($date);
            $event->setDescription($description);
            $event->setEmail($email);
            $event->setPhone($phone);
            $event->setAddress($address);
            $event->setUrl($url);
            $event->setFkEvents($fk_events);
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();
            $this->addFlash(
                    'notice',
                    'Event Edited'
                    );
            return $this->redirectToRoute('events');
        }

        /* now to make the form we will add this line form->createView() and now you can see the form in create.html.twig file  */
        return $this->render('events/edit.html.twig', array('event' => $event, 'form' => $form->createView())); 
    }


    #[Route("/events/details/{id}", name:"events_details")]
    public function details($id): Response
    {
        $event = $this->getDoctrine()->getRepository('App:Events')->find($id);
        return $this->render('events/details.html.twig', array('event' => $event));
    }

    #[Route("/events/delete/{id}", name:"event_delete")]
    public function delete($id){
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('App:Events')->find($id);
        $em->remove($event);
        $em->flush();
        $this->addFlash(
            'notice',
            'Event Removed'
        );
        return $this->redirectToRoute('events');

    }   

}

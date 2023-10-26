<?php

namespace App\Controller;
use App\Entity\Reader  ;
use App\Entity\Author ; 
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }
  
    #[Route('/au/{k}', name: 'app_author')]
    public function showAuthor($k): Response
    {
        return $this->render('author/msg.html.twig', [
            'name' => $k,
        ]);
    }
    #[Route('/authors', name: 'authors')]
    public function showAuthors(): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            
        return $this->render('author/list.html.twig', [
            'liste' => $authors,
        ]);
    }
    #[Route('/detail/{id}', name: 'details')]
    public function auhtorDetails($id): Response
    {
        $authors = array(
            array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' => 'victor.hugo@gmail.com ', 'nb_books' => 100),
            array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>  ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
            array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' => 'taha.hussein@gmail.com', 'nb_books' => 300),
            );
            $foundAuthor=0 ; 
            foreach ($authors as $author) {
                if ($author['id'] == $id) {
                    $foundAuthor = $author;
                    break; // Stop searching once a match is found
                }
            }

        return $this->render('author/details.html.twig', [
            'author' => $foundAuthor,
        ]);
    }

    #[Route('/fetch', name: 'fetch')]
    public function fetchtwoAuthors(AuthorRepository $repo){
$result=$repo->findAll();

return $this->render('author/authors.html.twig',[
    'auth'=>$result
]);
    }
    #[Route('/add', name: 'add')]
    public function addAuthor(ManagerRegistry $mr){
$autho=new Author();
$autho->setUsername('saker');
$autho->setEmail('saker@gmail.com');
$em=$mr->getManager();
$em->persist($autho);
$em->flush();
return $this->redirectToRoute('fetch');
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function removeAuthor(ManagerRegistry $mr,$id,AuthorRepository $repo){
        $author=$repo->find($id);
        $em=$mr->getManager();
        if($author!=null){
        $em->remove($author);
        $em->flush();
    }else{
        return new Response('id nexsite pas');
    }
        return $this->redirectToRoute('fetch'); 
    }
    #[Route('/addAuthorForm', name: 'addAuthorForm')]
    public function  addAuthorForm (Request  $request) 
{
    $author=new Author();
    $form =$this->CreateForm(AuthorType::class,$author);
  $form->add('Ajouter',SubmitType::class);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid())
    {
        $em=$this->getDoctrine()->getManager();
        $em->persist($author);
        $em->flush();
        return $this->redirectToRoute('fetch');
    }
    
    return $this->render('author/AddAuthorsForm.html.twig' ,['f'=>$form->createView()]);
}
    #[Route('/edit/{id}', name: 'app_edit')]
    public function edit(AuthorRepository $repository, $id, Request $request)
    {
        $author = $repository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->add('Edit', SubmitType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush(); 
            return $this->redirectToRoute("fetch");
        }

        return $this->render('author/edit.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/delete/{id}', name: 'app_delete')]
    public function delete($id, AuthorRepository $repository)
    {
        $author = $repository->find($id);

        if (!$author) {
            throw $this->createNotFoundException('Auteur non trouvé');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($author);
        $em->flush();

        return $this->redirectToRoute('fetch');
    }


}
        


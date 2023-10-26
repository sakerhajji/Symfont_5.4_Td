<?php

namespace App\Controller;
use App\Entity\Book;
use App\Entity\Author;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {
        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }

    #[Route('/addbook', name: 'addbook')]
    public function addstudent(ManagerRegistry $mr,AuthorRepository $repo): Response
    {
        $b = new Book();
        $author =$repo->find(1);
        $b->setTitle("i hate isrile ") ; 
        $b->setPublicationDate("14/10/2023") ; 
        $b->setIdAuthor($author) ; 
        $em = $mr->getManager();
        $em->persist($b);
        $em->flush();
        return new Response('added');
    }

    #[Route('/deletebook/{id}', name: 'deletebook')]
    public function removeAuthor(ManagerRegistry $mr,$id,BookRepository $repo){
        $b=$repo->find($id);
        $em=$mr->getManager();
        if($b!=null){
        $em->remove($b);
        $em->flush();
    }else{
        return new Response('id nexsite pas');
    }
        return new Response('deleted done .'); 
    }
    
    #[Route('/bookshow', name: 'bookshow')]
    public function fetchtwoBooks(BookRepository $repo){
        $result=$repo->findAll();
        
        return $this->render('book/books.html.twig',[
            'liste'=>$result
        ]);
            }

            #[Route('/deleteBook/{id}', name: 'app_delete')]
            public function delete($id, BookRepository $repository)
            {
                $book = $repository->find($id);
        
                if (!$book) {
                    throw $this->createNotFoundException('Book non trouvé');
                }
        
                $em = $this->getDoctrine()->getManager();
                $em->remove($book);
                $em->flush();
        
                return $this->redirectToRoute('bookshow');
            }
}




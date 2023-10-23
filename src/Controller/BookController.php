<?php

namespace App\Controller;

use App\Entity\Book;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    /**
     * Cette méthode permet de récupérer l'ensemble des livres
     *
     * @param BookRepository $bookRepository
     * @param SerializerInterface $serializer
     * @return JsonResponse
     */
    #[Route('/api/books', name: 'book', methods: ['GET'])]
    public function getBookList(BookRepository $bookRepository, SerializerInterface $serializer): JsonResponse
    {
        $bookList = $bookRepository->findAll();
        $jsonBookList = $serializer->serialize($bookList, 'json', ['groups' => 'getBooks']);
        return new JsonResponse($jsonBookList, Response::HTTP_OK, [], true);
    }

    
    /**
     * Cette méthode permet de récupérer un livre en particulier en fonction de son id. 
     *
     * @param SerializerInterface $serializer
     * @param Book $book
     * @return JsonResponse
     */
    #[Route("/api/books/{id}", name: "detailBook", methods: ['GET'])]
    public function getDetailBook(SerializerInterface $serializer, Book $book): JsonResponse
    {
        $jsonBook = $serializer->serialize($book, 'json', ['groups' => 'getBooks']);
        return new JsonResponse($jsonBook, Response::HTTP_OK, [], true);
    }

    /**
     * Cette méthode permet de supprimer un livre par rapport à son id. 
     *
     * @param Book $book
     * @param EntityManagerInterface $em
     * @return JsonResponse
     */
    #[Route('/api/books/{id}', name: 'deleteBook', methods: ['DELETE'])]
    public function deleteBook(Book $book, EntityManagerInterface $em): JsonResponse
    {
        $em->remove($book);
        $em->flush();
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}

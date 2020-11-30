<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/categories", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     *
     * @Route("/", name="_index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();

        return $this->render("category/index.html.twig", [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route (
     *     "/{categoryName}",
     *     name="show",
     *     methods={"GET"}
     *     )
     * @param string $categoryName
     */

    public function show(string $categoryName): Response
    {
        if (!$categoryName) {
            throw $this->createNotFoundException(
                'no category named : ' . $categoryName . ' found in category\'s table.'
            );
        }
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findByCategory($categoryName);

        if (!$programs) {
            throw $this->createNotFoundException(
                'Aucune série trouvée'
            );
        }
        return $this->render('category/show.html.twig', [
            'category' => $categoryName,
            'programs' => $programs,
        ]);
    }
}

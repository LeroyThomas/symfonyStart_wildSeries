<?php


namespace App\Controller;

use App\Entity\Category;
use App\Entity\Program;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * Class CategoryController
 * @package App\Controller
 * @Route("/categories", name="category_")
 */
class CategoryController extends AbstractController
{
    /**
     *
     * @Route("/", name="index")
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
     * @Route("/new", name="new")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */
    public function new(Request $request) : Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        // Was the form submitted ?
        if ($form->isSubmitted()) {
            // Deal with the submitted data
            // Get the Entity Manager
            $entityManager = $this->getDoctrine()->getManager();
            // Persist Category Object
            $entityManager->persist($category);
            // Flush the persisted object
            $entityManager->flush();
            // Finally redirect to categories list
            return $this->redirectToRoute('category_index');
        }
        return $this->render('category/new.html.twig', [
            "form" => $form->createView(),
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
        $programs= $this->getDoctrine()
            ->getRepository(Program::class)
            ->findBy(
                [],
                ['id' => 'DESC'],
                3
            );

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

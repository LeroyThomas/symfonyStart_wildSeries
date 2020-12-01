<?php
namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProgramController
 * @package App\Controller
 * @Route("/programs", name="program_")
 */
class ProgramController extends AbstractController
{

    /**
     * Show all rows from Program's entity
     *
     * @Route("/", name="index")
     * @return Response A response instance
     */
    public function index(): Response
    {
        $programs = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findAll();

        return $this->render('program/index.html.twig', [
            'programs' => $programs
        ]);
    }

    /**
     * Getting a program by id
     *
     * @Route("/show/{id<^[0-9]+$>}", name="show")
     * @return Response
     */
    public function show(int $id): Response
    {
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->findOneBy(['id' => $id]);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }

//        $seasons = $this->getDoctrine()
//            ->getRepository(Season::class)
//            ->findAll();
//        if (!$seasons) {
//            throw $this->createNotFoundException(
//                'Pas de saisons'
//            );
//        }
        $seasons = $program->getSeasons();
        return $this->render('program/show.html.twig', [
            'program' => $program,
            'seasons' => $seasons,
            ]);
    }

    /**
     * @Route("/programs/{programId}/seasons/{seasonId}",
     *     name="season_show")
     * @param int $programId
     * @param int $seasonId
     */
    public function showSeason(int $programId, int $seasonId)
    {
        if(!$programId) {
            throw $this->createNotFoundException(
                'Pas d\'id correspondant au programme'
            );
        }
        if(!$seasonId) {
            throw $this->createNotFoundException(
                'Pas d\'id correspondant à la saison'
            );
        }
        $program = $this->getDoctrine()
            ->getRepository(Program::class)
            ->find($programId);
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $programId . ' found in program\'s table.'
            );
        }
        $season = $this->getDoctrine()
            ->getRepository(Season::class)
            ->find($seasonId);
        if (!$season) {
            throw $this->createNotFoundException(
                'No program with id : ' . $seasonId . ' found in program\'s table.'
            );
        }
        $episodes = $season->getEpisodes();

//        $episode = $this->getDoctrine()
//            ->getRepository(Episode::class)
//            ->findAll();

        return $this->render('program/season_show.html.twig', [
            'program' => $program,
            'season' => $season,
            'episodes' => $episodes,
        ]);
    }
}

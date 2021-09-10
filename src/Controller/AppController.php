<?php


namespace App\Controller;


use App\Entity\Club;
use App\Repository\TeamPlayerRepository;
use App\Repository\TeamRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TeamController
 * @package App\Controller
 *
 * @IsGranted("ROLE_MANAGER")
 */
class AppController extends AbstractController
{

    /**
     * @Route("/no_club", name="app_no_club")
     */
    public function no_club(): Response
    {
        // TODO create template
        return $this->Response('It seems that you don\'t have any club. Contact admin');
    }

    /**
     * @Route("/select_club", name="app_select_club")
     */
    public function select_club(): Response
    {
        // TODO to be implemented
        return $this->Response('To be implemented!');
    }

    /**
     * @Route("/clubs", name="app_club_list")
     */
    public function listClubs(TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        $clubs = $user->getClubs();
        if ($clubs->count() === 0) {
            // no club for connected manager
            return $this->redirectToRoute('app_no_club');
        }

        if ($clubs->count() > 1) {
            // many club for logged in manager
            // TODO redirect to select a club
            // return $this->redirectToRoute('app_select_club');
        }

        $club = $clubs->first();

        return $this->redirectToRoute('app_team_list', ['slug' => $club->getSlug()]);
    }

    /**
     * @Route("/{slug}/teams", name="app_team_list")
     */
    public function listTeams(Club $club, TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findBy(['club' => $club]);

        return $this->render('team/list.html.twig', array(
            'club' => $club,
            'teams' => $teams
        ));
    }

    /**
     * @Route("/teams/{slug}/{level}", name="app_team_show")
     */
    public function showTeam($slug, $level, TeamRepository $teamRepository, TeamPlayerRepository $teamPlayerRepository): Response
    {
        $user = $this->getUser();
        $team = $teamRepository->findOneBySlugAndLevel($user, $slug, $level);

        $team_players = $teamPlayerRepository->findByTeam($team);
        $seasons = [];
        $players = [];
        foreach ($team_players as $team_player)
        {
            $season = $team_player->getSeason();
            if (!in_array($season, $seasons))
            {
                $seasons[$season->getId()] = $season;
            }
            if (!isset($players[$season->getId()]))
            {
                $players[$season->getId()] = [];
            }
            $players[$season->getId()][] = $team_player->getPlayer();
        }

        return $this->render('team/show.html.twig', array(
            'team' => $team,
            'seasons' => $seasons,
            'players' => $players
        ));
    }
}
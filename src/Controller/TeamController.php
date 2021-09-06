<?php


namespace App\Controller;


use App\Repository\TeamPlayerRepository;
use App\Repository\TeamRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{

    /**
     * @Route("/")
     */
    public function home(): Response
    {
        return new Response('Sound like great feature!');
    }

    /**
     * @Route("/teams", name="team_list")
     */
    public function listTeams(TeamRepository $teamRepository): Response
    {
        $user = $this->getUser();
        $teams = $teamRepository->findBy(['owner' => $user]);

        return $this->render('team/list.html.twig', array(
            'teams' => $teams
        ));
    }

    /**
     * @Route("/teams/{slug}/{level}", name="team_show")
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
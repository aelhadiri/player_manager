<?php

namespace App\Tests\Controller;

use App\Repository\UserRepository;
use PHPUnit\Framework\Constraint\LogicalAnd;
use Symfony\Bundle\FrameworkBundle\Test\TestBrowserToken;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Test\Constraint as ResponseConstraint;
use Symfony\Component\Security\Core\User\UserInterface;

class AppControllerTest extends WebTestCase
{
    public function testAccessDeniedForAnonymousUsers1()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseRedirects('/login', 302, 'xx');
    }

    public function getUrlsForAnonymousUsers(): ?\Generator
    {
        yield ['GET', '/', '/login'];
        yield ['GET', '/admin', '/login'];
    }

    /**
     * @dataProvider getUrlsForAnonymousUsers
     */
    public function testAccessDeniedForAnonymousUsers(string $httpMethod, string $url, string $expectedLocation): void
    {
        $client = static::createClient();
        $client->request($httpMethod, $url);

        $this->assertResponseRedirects(
            $expectedLocation,
            Response::HTTP_FOUND,
            sprintf('The %s secure URL redirects to the login form.', $url)
        );
    }

    public function getUrlsForClubManagers(): ?\Generator
    {
        yield ['GET', '/', 'club.manager_1@example.com', '/clubs'];
        yield ['GET', '/clubs', 'club.manager_1@example.com', '/club-1/teams'];
        yield ['GET', '/clubs', 'club.manager_2@example.com', '/club-2/teams'];
    }

    /**
     * @dataProvider getUrlsForClubManagers
     */
    public function testIndexLoggedUser(string $httpMethod, string $url, string $userEmail, string $expectedLocation): void
    {
        $client = static::createClient();

        $userRepository = static::getContainer()->get(UserRepository::class);

        $testUser = $userRepository->findOneByEmail($userEmail);
        $client->loginUser($testUser);
        $client->request($httpMethod, $url);

        $this->assertResponseRedirects(
            $expectedLocation,
            Response::HTTP_FOUND,
            sprintf('The %s secure URL redirects to the login form.', $url));

    }





    public function getUrlsForAdmins(): ?\Generator
    {
        yield ['GET', '/'];
        yield ['GET', '/admin'];
    }


//    public function testsIndessxLoggedUser()
//    {
//        $client = static::createClient();
//        $client->request('GET', '/');
//
//        $userRepository = static::$container->get(UserRepository::class);
//        $testUser = $userRepository->findOneByEmail('admin@example.com');
//
//        $client->loginUser($testUser);
//
//        $this->assertResponseRedirects();
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Please sign in');
//    }
}

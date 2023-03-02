<?php

namespace App\Tests\User;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class ProfileControllerTest extends WebTestCase
{
    /**
     * testAccessRouteWithoutLogin
     * Rest l'existance de la route /login pour la connexion
     *
     * @return void
     */
    public function testAccessRouteWithoutLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/profile');
        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }
    
    /**
     * testAccessRouteWithRoleAdmin
     *
     * @return void
     */
    public function testAccessRouteWithRoleAdmin(): void
    {
        $client = static::createClient();

        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);

        /** @var UserInterface $testUser */
        $testUser = $userRepository->findOneBy(['username' => 'admin81']);
        $client->loginUser($testUser);

        $client->request('GET', '/profile');

        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }
    
    /**
     * testAccessRouteWithRoleClub
     *
     * @return void
     */
    public function testAccessRouteWithRoleClub(): void
    {
        $client = static::createClient();
        /** @var UserRepository $userRepository */
        $userRepository = static::getContainer()->get(UserRepository::class);

        /** @var UserInterface $testUser */
        $testUser = $userRepository->findOneBy(['username' => 'club81']);
        $client->loginUser($testUser);

        $client->request('GET', '/profile');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
    }
}
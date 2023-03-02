<?php

namespace App\Tests\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{    
    /**
     * testExistsRouteLogin
     * Rest l'existance de la route /login pour la connexion
     *
     * @return void
     */
    public function testExistsRouteLogin(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');
        $this->assertResponseIsSuccessful();
    }
    
    /**
     * testLoginWithGoodCredentialsAndRoleAdmin
     * Test la connexion pour un utilisateur avec le role admin avec de bon credentials
     *
     * @return void
     */
    public function testLoginWithGoodCredentialsAndRoleAdmin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Connectez-vous')->form();
        $form['_username'] = 'admin81';
        $form['_password'] = '0000';
        $crawler = $client->submit($form);

        $this->assertResponseRedirects('/admin', Response::HTTP_FOUND);
    }
    
    /**
     * testLoginWithGoodCredentialsAndRoleClub
     *
     * @return void
     */
    public function testLoginWithGoodCredentialsAndRoleClub(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Connectez-vous')->form();
        $form['_username'] = 'club81';
        $form['_password'] = '0000';
        $crawler = $client->submit($form);

        $this->assertResponseRedirects('/profile', Response::HTTP_FOUND);
    }
    
    /**
     * testLoginBadGoodCredentialsAndRoleAdmin
     * Test la connexion pour un utilisateur avec le role admin avec de mauvais credentials
     *
     * @return void
     */
    public function testLoginBadGoodCredentialsAndRoleAdmin(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');

        $form = $crawler->selectButton('Connectez-vous')->form();
        $form['_username'] = 'admin8';
        $form['_password'] = '000011561';
        $crawler = $client->submit($form);

        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }
}
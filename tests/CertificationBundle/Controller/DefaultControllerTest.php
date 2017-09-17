<?php

namespace CertificationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    /**
     * @test
     */
    public function eventGetsTriggered(){
        $client = WebTestCase::createClient();
        $client->enableProfiler();
        //$crawler = $client->request('GET','/certification/dispatcher/');
        $client->request('GET','/certification/dispatcher/');
        $profile = $client->getProfile();
       // dump($profile->getStatusCode());
        $this->assertContains(
            'malu.event dispatched',
            $client->getResponse()->getContent()
        );
    }

    /**
     * @test
     */
    public function linkGetsFollowed(){
        $client = WebTestCase::createClient();
        $crawler = $client->request('GET','/certification/');

        $link = $crawler->filter('a:contains("Basic validation")')->link();

        $client->click($link);

        $this->assertContains(
            'Needs to be at least 3 chars long',
            $client->getResponse()->getContent()
        );

        $client->back();

        $this->assertNotContains(
            'Needs to be at least 3 chars long',
            $client->getResponse()->getContent()
        );

        $history = $client->getHistory();

      //  dump($history);

    }
}

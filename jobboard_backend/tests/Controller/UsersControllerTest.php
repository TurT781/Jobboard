<?php

namespace App\Tests\Controller;

use App\Entity\Users;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class UsersControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/users/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Users::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'user[email]' => 'Testing',
            'user[roles]' => 'Testing',
            'user[password]' => 'Testing',
            'user[first_name]' => 'Testing',
            'user[last_name]' => 'Testing',
            'user[phone_number]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setEmail('My Title');
        $fixture->setRoles('My Title');
        $fixture->setPassword('My Title');
        $fixture->setFirst_name('My Title');
        $fixture->setLast_name('My Title');
        $fixture->setPhone_number('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('User');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setEmail('Value');
        $fixture->setRoles('Value');
        $fixture->setPassword('Value');
        $fixture->setFirst_name('Value');
        $fixture->setLast_name('Value');
        $fixture->setPhone_number('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'user[email]' => 'Something New',
            'user[roles]' => 'Something New',
            'user[password]' => 'Something New',
            'user[first_name]' => 'Something New',
            'user[last_name]' => 'Something New',
            'user[phone_number]' => 'Something New',
        ]);

        self::assertResponseRedirects('/users/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getRoles());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getFirst_name());
        self::assertSame('Something New', $fixture[0]->getLast_name());
        self::assertSame('Something New', $fixture[0]->getPhone_number());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Users();
        $fixture->setEmail('Value');
        $fixture->setRoles('Value');
        $fixture->setPassword('Value');
        $fixture->setFirst_name('Value');
        $fixture->setLast_name('Value');
        $fixture->setPhone_number('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/users/');
        self::assertSame(0, $this->repository->count([]));
    }
}

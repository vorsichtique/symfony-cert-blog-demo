<?php


namespace AppBundle\Command;


use AppBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListUsersCommand extends Command
{

    private $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();

        $this->entityManager = $em;
    }

        public function configure()
    {
        $this
            ->setName('app:list-users')
            ->addOption('max-results', null, InputOption::VALUE_OPTIONAL, 'Limits the number of users listed', 50);

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $maxResults = $input->getOption('max-results');
        $users = $this->entityManager->getRepository(User::class)->findBy([], [], $maxResults);

        foreach ($users as $user) {
            $output->writeln($user->getUsername());
        }
    }
}
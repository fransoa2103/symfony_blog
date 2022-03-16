<?php

namespace App\Command;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:publish-article',
    description: 'update daily or by to type log command, the articles in DB from -to publish- state to -publish- state',
)]

// For create this command, you need ArticleRepository::class to quest the DB
// and need Manager::Class to update Article entity

class PublishArticleCommand extends Command
{
    private $articleRepository;
    private $manager;

    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $manager, string $name = null)
    {
        $this->articleRepository= $articleRepository;
        $this->manager= $manager;
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this->setDescription('Publication des articles');
        
    }
    
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $articles = $this->articleRepository->findBy(['state' => 'to publish']);
        foreach($articles as $article)
        {
            $article->setState('publish');
        }
        $this->manager->flush();
        
        $io->success(count($articles).' articles publiés.');

        return Command::SUCCESS;
    }
}

<?php

namespace Kolomiets\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindWaitingPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:posted:check')

            // the short description shown while running "php bin/console list"
            ->setDescription('This command checks if there are pending posts')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command checks if there are pending posts')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $posts = $em->getRepository('KolomietsBlogBundle:Post')->findPendingPosts();

        if($posts) {
            $output->writeln('<info>Found '.count($posts).' posts to posted</>');
        } else {
            $output->writeln('No pending posts found!');
        }
    }
}
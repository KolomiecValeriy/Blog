<?php

namespace Kolomiets\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class PostedWaitingPostsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('blog:posted:add')

            // the short description shown while running "php bin/console list"
            ->setDescription('This command added all pending posts')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command added all pending posts to blog')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.default_entity_manager');
        $posts = $em->getRepository('KolomietsBlogBundle:Post')->findPendingPosts();

        if($posts) {
            $count = 0;
            foreach ($posts as $post) {
                $post->setPosted(true);
                $count++;
            }
            $em->flush();
            $output->writeln('<info>'.$count.' post(s) successfully aded</>');
        } else {
            $output->writeln('No posts found to add!');
        }
    }
}
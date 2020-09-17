<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;


class SocialController extends AbstractController
{
    /**
     * @Route("/social-finder", name="social-finder")
     */
    public function index()
    {
        $finder = new Finder();
        $finder->files()->in($this->getParameter('videos_directory'));

        foreach ($finder as $file) {
            // dumps the absolute path
            // var_dump($file->getRealPath());

            // dumps the relative path to the file, omitting the filename
            // var_dump($file->getRelativePath());

            // dumps the relative path to the file
            var_dump($file->getRelativePathname());
        }
        return $this->render('social/index.html.twig', [
            'controller_name' => 'SocialController',
        ]);
    }

    /**
     * @Route("/social-create", name="social-create")
     */
    public function indexCreate()
    {
        $filesystem = new Filesystem();

        try {
            $filesystem->mkdir($this->getParameter('videos_directory').'/'.'probando');
        } catch (IOExceptionInterface $exception) {
            echo "An error occurred while creating your directory at ".$exception->getPath();
        }
        return $this->render('social/index.html.twig', [
            'controller_name' => 'SocialController',
        ]);
    }
}

<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
            
            //Nowe bundle
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Ob\HighchartsBundle\ObHighchartsBundle(),
            new Gregwar\ImageBundle\GregwarImageBundle(),

            new Tutto\DataGridBundle\TuttoDataGridBundle(),
            new Tutto\SecurityBundle\TuttoSecurityBundle(),
            new Tutto\CommonBundle\TuttoCommonBundle(),
            new Tutto\XhtmlBundle\TuttoXhtmlBundle(),
            new Tutto\FileBundle\TuttoFileBundle(),

            new Apihour\FrontendBundle\ApihourFrontendBundle(),
            new Apihour\UserBundle\ApihourUserBundle(),
            new Apihour\MenuBundle\ApihourMenuBundle(),
            new Apihour\FileBundle\ApihourFileBundle(),
            new Apihour\UtilBundle\ApihourUtilBundle(),
            new Apihour\ContractorBundle\ApihourContractorBundle(),
            new Apihour\ProductBundle\ApihourProductBundle(),
            new Apihour\InvoiceBundle\ApihourInvoiceBundle()

        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Acme\DemoBundle\AcmeDemoBundle();
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();

            $bundles[] = new Apihour\ExampleBundle\ApihourExampleBundle();
        }
        
        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
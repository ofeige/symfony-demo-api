<?php

return [
    Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle::class => ['all' => true],
    Doctrine\Bundle\DoctrineBundle\DoctrineBundle::class => ['all' => true],
    Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle::class => ['all' => true],
    Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle::class => ['dev' => true, 'test' => true],
    FOS\RestBundle\FOSRestBundle::class => ['all' => true],
    Symfony\Bundle\TwigBundle\TwigBundle::class => ['all' => true],
    Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle::class => ['all' => true],
    Symfony\Bundle\WebProfilerBundle\WebProfilerBundle::class => ['dev' => true, 'test' => true],
    Nelmio\ApiDocBundle\NelmioApiDocBundle::class => ['all' => true],
    Symfony\Bundle\SecurityBundle\SecurityBundle::class => ['all' => true],
    Lexik\Bundle\JWTAuthenticationBundle\LexikJWTAuthenticationBundle::class => ['all' => true],
    KnpU\LoremIpsumBundle\KnpULoremIpsumBundle::class => ['all' => true],
    Shopping\ApiTKHeaderBundle\ShoppingApiTKHeaderBundle::class => ['all' => true],
    Shopping\ApiTKCommonBundle\ShoppingApiTKCommonBundle::class => ['all' => true],
    Shopping\ApiTKDeprecationBundle\ShoppingApiTKDeprecationBundle::class => ['all' => true],
    Shopping\ApiTKDtoMapperBundle\ShoppingApiTKDtoMapperBundle::class => ['all' => true],
    Shopping\ApiTKUrlBundle\ShoppingApiTKUrlBundle::class => ['all' => true],
];

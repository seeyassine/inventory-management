<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity()]
#[ORM\Table(name: 'refresh_tokens')]
class RefreshToken  extends BaseRefreshToken
{
   // Rien d'autre n'est nécessaire !  lea classe hérite de tout le comportement requis. Le bundle s'occupe de tout le reste ! 
}

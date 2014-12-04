<?php

namespace Cresta\AulasBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class CrestaAulasBundle extends Bundle
{
	public function getParent()
    {
        return 'FOSUserBundle';
    }
}
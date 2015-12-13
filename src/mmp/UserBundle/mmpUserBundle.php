<?php

namespace mmp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class mmpUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}

<?php

namespace HeimrichHannot\NoUiSliderBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class HeimrichHannotNoUiSliderBundle extends Bundle
{
    public function getPath()
    {
        return \dirname(__DIR__);
    }

}
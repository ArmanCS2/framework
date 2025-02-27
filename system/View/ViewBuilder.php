<?php

namespace System\View;

use System\View\Traits\HasExtendsContent;
use System\View\Traits\HasIncludesContent;
use System\View\Traits\HasViewLoader;

class ViewBuilder
{
    use HasViewLoader, HasExtendsContent, HasIncludesContent;

    public $content;
    public $vars = [];

    public function run($dir)
    {
        $this->content = $this->viewLoader($dir);
        $this->checkExtendsContent();
        $this->checkIncludesContent();
        Composer::setViews($this->viewNames);
        $this->vars = Composer::getVars();

    }
}

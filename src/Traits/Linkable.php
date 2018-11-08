<?php

namespace Cloudteam\BaseCore\Traits;

trait Linkable
{
    /**
     * @param string $text
     * @param string $font
     *
     * @return string
     */
    public function getViewLink($text = null, $font = 'brand'): string
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = route("{$this->route}.show", $this, false);

        return "<a target='_blank' class='m-link m--font-bolder m--font-{$font}' href='$route'>$modelValName</a>";
    }

    /**
     * @param string $text
     * @param string $font
     *
     * @return string
     */
    public function getEditLink($text = null, $font = 'brand'): string
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = route("{$this->route}.edit", $this, false);

        return "<a target='_blank' class='m-link m--font-bolder m--font-{$font}' href='$route'>$modelValName</a>";
    }
}
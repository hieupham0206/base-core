<?php

namespace Cloudteam\BaseCore\Traits;

trait Linkable
{
    /**
     * @param bool $absolute: Đường dẫn tuyệt đối
     *
     * @return string
     */
    public function getViewLink($absolute = false): string
    {
        return route("{$this->route}.show", $this, $absolute);
    }

    /**
     * @param bool $absolute: Đường dẫn tuyệt đối
     * @return string
     */
    public function getEditLink($absolute = false): string
    {
        return route("{$this->route}.edit", $this, $absolute);
    }

    /**
     * @return string
     */
    public function getDestroyLink(): string
    {
        return route("{$this->route}.destroy", $this, false);
    }

    /**
     * @param string $text
     * @param string $font
     *
     * @return string
     */
    public function getViewLinkText($text = null, $font = 'brand'): string
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = $this->getViewLink();

        return "<a target='_blank' class='kt-link kt-font-bolder kt-font-{$font}' href='$route'>$modelValName</a>";
    }

    /**
     * @param string $text
     * @param string $font
     *
     * @return string
     */
    public function getEditLinkText($text = null, $font = 'brand'): string
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = $this->getEditLink();

        return "<a target='_blank' class='kt-link kt-font-bolder kt-font-{$font}' href='$route'>$modelValName</a>";
    }
}

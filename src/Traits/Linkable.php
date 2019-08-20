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
        return route("{$this->getTable()}.show", $this, $absolute);
    }

    /**
     * @param bool $absolute: Đường dẫn tuyệt đối
     * @return string
     */
    public function getEditLink($absolute = false): string
    {
        return route("{$this->getTable()}.edit", $this, $absolute);
    }

    /**
     * @param bool $absolute: Đường dẫn tuyệt đối
     * @return string
     */
    public function getDestroyLink($absolute = false): string
    {
        return route("{$this->getTable()}.destroy", $this, $absolute);
    }

    /**
     * @param string $text
     * @param string $font
     * @param bool $absolute
     *
     * @return string
     */
    public function getViewLinkText($text = null, $font = 'brand', $absolute = false): string
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = $this->getViewLink($absolute);

        return "<a target='_blank' class='kt-link kt-font-bolder kt-font-{$font}' href='$route'>$modelValName</a>";
    }

    /**
     * @param string $text
     * @param string $font
     * @param bool $absolute
     * @return string
     */
    public function getEditLinkText($text = null, $font = 'brand', $absolute = false): string
    {
        $modelValName = $text ?? $this->{$this->displayAttribute};

        $route = $this->getEditLink($absolute);

        return "<a target='_blank' class='kt-link kt-font-bolder kt-font-{$font}' href='$route'>$modelValName</a>";
    }
}

<?php

namespace Cloudteam\BaseCore\Traits;

/**
 * Trait HasLabel
 * @package App\Traits
 */
trait Labelable
{
    /**
     * @param $field
     *
     * @return array|null|string
     */
    public function label($field = '')
    {
        $label = __(ucfirst(camel2words(strtolower($field))));

        if (property_exists(\get_class($this), 'labels') && \is_array($this->labels) && array_key_exists($field, $this->labels)) {
            $label = $this->labels[$field];
            $label = \is_callable($label) ? $label($field) : (string) $label;
        }

        return $label;
    }

    /**
     * @param bool $lcfirst
     *
     * @return array|null|string
     * @throws \ReflectionException
     */
    public function classLabel($lcfirst = false)
    {
        $reflect   = new \ReflectionClass($this);
        $tableName = __(camel2words(studly_case($reflect->getShortName())));
        if (property_exists(\get_class($this), 'logName')) {
            $tableName = __($reflect->getStaticPropertyValue('logName'));
        }

        return $lcfirst ? mb_strtolower($tableName) : $tableName;
    }

    /**
     * @param $text
     * @param string $context
     *
     * @return string
     */
    public function contextLabel($text, $context = 'success'): string
    {
        return '<span class="font-weight-bold m--font-' . $context . '">' . $text . '</span>';
    }

    /**
     * @param $text
     * @param string $context
     *
     * @return string
     */
    public function contextBadge($text, $context = 'success'): string
    {
        return '<span class="m-badge m-badge--' . $context . ' m-badge--wide m-badge--rounded">' . $text . '</span>';
    }
}
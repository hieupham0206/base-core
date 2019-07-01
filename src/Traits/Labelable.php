<?php

namespace Cloudteam\BaseCore\Traits;

use function get_class;
use function is_array;
use function is_callable;
use ReflectionClass;
use ReflectionException;

/**
 * Trait HasLabel
 * @package App\Traits
 */
trait Labelable
{
    /**
     * @param $field
     *
     * @return null|string
     */
    public function label($field = '')
    {
        $label = __(ucfirst(camel2words(strtolower($field))));

        if (property_exists(get_class($this), 'labels')
            && is_array($this->labels)
            && array_key_exists($field, $this->labels)
        ) {
            $label = $this->labels[$field];
            $label = is_callable($label) ? $label($field) : (string) $label;
        }

        return $label;
    }

    /**
     * @param bool $lcfirst
     *
     * @return null|string
     * @throws ReflectionException
     */
    public function classLabel($lcfirst = false)
    {
        $reflect   = new ReflectionClass($this);
        $tableName = __(camel2words(studly_case($reflect->getShortName())));
        if (property_exists(get_class($this), 'logName')) {
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
        return '<span class="font-weight-bold kt-font-' . $context . '">' . $text . '</span>';
    }

    /**
     * @param $text
     * @param string $context
     *
     * @return string
     */
    public function contextBadge($text, $context = 'success'): string
    {
        return '<span class="font-weight-bold kt-badge kt-badge--inline kt-badge--rounded kt-badge--' . $context . '">' . $text . '</span>';
    }

    /**
     * @param $text
     * @param string $context
     *
     * @return string
     */
    public function contextBadgeUnified($text, $context = 'success'): string
    {
        return '<span class="font-weight-bold kt-badge kt-badge--inline kt-badge--rounded kt-badge--unified-' . $context . '">' . $text . '</span>';
    }
}
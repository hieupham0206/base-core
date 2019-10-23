<?php
/**
 * User: ADMIN
 * Date: 23/10/2019 9:50 SA
 */

namespace Cloudteam\BaseCore\Utils;

class HtmlAction
{
    public static function generateButtonChangeState($params)
    {
        [$state, $message, $title, $url, $elementTitle, $icon] = $params;

        return sprintf(' <button type="button" class="btn-action-change-state" data-state="%s" data-message="%s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>',
            $state, $message, $title, $url, $elementTitle, $icon);
    }

    public static function generateButtonDelete($deleteLink, $dataTitle)
    {
        return sprintf(" <button type='button' class='btn-action-delete' data-title='%s' data-url='%s' title='%s'><i class='far fa-trash'></i></button>", $dataTitle, $deleteLink, __('Delete'));
    }

    public static function generateButtonEdit($editLink)
    {
        return sprintf(" <a href='%s' class='btn-action-edit' title='%s'><i class='far fa-edit'></i></a>", $editLink, __('Edit'));
    }

    public static function generateButtonView($viewLink)
    {
        return sprintf(' <a href="%s" class="btn-action-view" title="%s"><i class="far fa-eye"></i></a>', $viewLink, __('View'));
    }

    public static function generateCustomButton($cssClass, $dataTitle, $link, $title)
    {
        return sprintf(' <button type="button" class="btn-action %s" data-title="%s" data-url="%s" title="%s"><i class="far fa-key"></i></button>'
            , $cssClass, $dataTitle, $link, $title);
    }
}

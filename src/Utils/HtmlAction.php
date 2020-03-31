<?php
/**
 * User: ADMIN
 * Date: 23/10/2019 9:50 SA
 */

namespace Cloudteam\BaseCore\Utils;

class HtmlAction
{
    private static function createCustomButtonClass($btnClass = '')
    {
        return $btnClass ?: "btn-action $btnClass";
    }

    public static function generateButtonChangeState($params, $btnClass = '')
    {
        $btnClass = self::createCustomButtonClass($btnClass);

        [$state, $message, $title, $url, $elementTitle, $icon] = $params;

        return sprintf(' <button type="button" class="btn-action-change-state %s" data-state="%s" data-message="%s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>',
            $btnClass, $state, $message, $title, $url, $elementTitle, $icon);
    }

    public static function generateButtonDelete($deleteLink, $dataTitle, $btnClass = '')
    {
        $btnClass = self::createCustomButtonClass($btnClass);

        return sprintf(" <button type='button' class='btn-action-delete %s' data-title='%s' data-url='%s' title='%s'><i class='far fa-trash'></i></button>", $btnClass, $dataTitle, $deleteLink, __('Delete'));
    }

    public static function generateButtonEdit($editLink, $btnClass = '')
    {
        $btnClass = self::createCustomButtonClass($btnClass);

        return sprintf(" <a href='%s' class='btn-action-edit %s' title='%s'><i class='far fa-edit'></i></a>", $editLink, $btnClass, __('Edit'));
    }

    public static function generateButtonView($viewLink, $btnClass = '')
    {
        $btnClass = self::createCustomButtonClass($btnClass);

        return sprintf(' <a href="%s" class="btn-action-view %s" title="%s"><i class="far fa-eye"></i></a>', $viewLink, $btnClass, __('View'));
    }

    public static function generateCustomButton($params)
    {
        [$cssClass, $dataTitle, $link, $title, $icon] = $params;

        return sprintf(' <button type="button" class="btn-action %s" data-title="%s" data-url="%s" title="%s"><i class="%s"></i></button>'
            , $cssClass, $dataTitle, $link, $title, $icon);
    }

    public static function generateDropdownButton($buttons, $btnClass = 'btn-gray')
    {
        $buttonHtml = implode(' ', $buttons);

        return " <div class=\"dropdown dropdown-inline\">
                            <button type=\"button\" class=\"btn-action $btnClass\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                <i class=\"far fa-ellipsis-h\"></i>
                            </button>
                               <div class=\"form-group dropdown-menu dropdown-menu-right row text-center\">$buttonHtml</div>
                        </div>";
    }
}

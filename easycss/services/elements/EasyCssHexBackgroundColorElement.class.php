<?php

/* #################################################
 *                           EasyCssHexBackgroundColorElement.class.php
 *                            -------------------
 *   begin                : 2016/05/18
 *   copyright            : (C) 2016 Toss
 *   email                : t0ssp4p3r@gmail.com
 *
 *
  ###################################################
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 *
  ################################################### */

/**
 * Description of EasyCssHexBackgroundColorElement
 *
 * @author PaperToss
 */
class EasyCssHexBackgroundColorElement extends EasyCssHexColorElement
{
    /** @staticvar array Regex */
    public static $regex = [
        '`(?<=[^-])background-color\s*:\s*#([a-f0-9]{3,6})\s*;`isU',
    ];
    
    public function get_templates()
    {
        $color_tpl = $this->color->get_form(LangLoader::get_message('background_color_description', 'common', 'easycss'));
        $begin = new StringTemplate('<div class="easycss-field">');
        $end = new StringTemplate('</div>');
        AdminEasyCssEditController::add_field_to_hidden_input($this->parent_id . '/' . $this->id);
        return array($begin, $color_tpl, $end);
    }

    public function get_text_to_file()
    {
        return 'background-color : #' . $this->color->get_color() . ';';
    }
}

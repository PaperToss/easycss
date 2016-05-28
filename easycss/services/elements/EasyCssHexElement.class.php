<?php

/* #################################################
 *                           EasyCssHexElement.class.php
 *                            -------------------
 *   begin                : 2016/05/22
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
 * Description of EasyCssHexElement
 *
 * @author Toss
 */
class EasyCssHexElement extends EasyCssAbstractElement
{

    protected $color;
    protected $color_id;

    public function __construct($id, $parent_id, $value)
    {
        parent::__construct($id, $parent_id, $value);
        $this->color_id = $this->parent_id . '/' . $this->id . '_color';
        preg_match('`^\s*#([0-9a-fA-F]{6}|[0-9a-fA-F]{3})\s*$`i', $value, $matches);

        $this->color = new EasyCssHexColorValue($this->color_id, $matches[1]);
    }

    public function get_templates($label = false)
    {
        if ($label === false)
        {
            $label = LangLoader::get_message('color_description', 'common', 'easycss');
        }
        AdminEasyCssEditController::add_field_to_hidden_input($this->parent_id . '/' . $this->id);
        return [$this->color->get_form($label)];
    }

    public function set_value_from_post(\HTTPRequestCustom $request)
    {
        $color_value = $request->get_poststring($this->color_id, false);
        $color_modif = $this->color->set_value($color_value);

        if ($color_modif)
            return $this->get_text_to_file();
        return false;
    }

    public function get_text_to_file()
    {
        return '#' . $this->color->get_color();
    }

}

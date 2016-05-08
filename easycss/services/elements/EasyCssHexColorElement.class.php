<?php

/* #################################################
 *                           EasyCssHexColorElement.class.php
 *                            -------------------
 *   begin                : 2016/04/22
 *   copyright            : (C) 2016 PaperToss
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
 * Description of EasyCssHexColorElement
 *
 * @author Toss
 */
class EasyCssHexColorElement extends EasyCssAbstractElement
{

    /** @var boolean modifiable */
    public static $can_modify = true;
    
    public $to_display = true;
    
    /** @var \EasyCssHexColorField */
    protected $color;
    
    

    public function __construct($id, $parent_id, $value)
    {
        $this->parent_id = $parent_id;
        $this->color = new EasyCssHexColorField($parent_id . '/' . $id, $value);
        $this->id = $id;
    }

    public function get_templates()
    {
        $color_tpl = $this->color->getForm(LangLoader::get_message('color_description', 'common', 'easycss'));
        $begin = new StringTemplate('<div class="easycss-field">');
        $end = new StringTemplate('</div>');
        AdminEasyCssEditController::add_field_to_hidden_input($this->parent_id . '/' . $this->id);
        return array($begin, $color_tpl,$end);
    }

    public function getTextToFile()
    {
        return 'color : #' . $this->color->getColor() .';';
    }
    
    public function setValueFromPost(\HTTPRequestCustom $request)
    {
        $color_value = $request->get_poststring($this->parent_id . '/' . $this->id, false);
        return $this->color->setValue($color_value);
    }

}

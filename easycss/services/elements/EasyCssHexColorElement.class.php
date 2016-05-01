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

    /** Couleur de la forme color : rgba( ; */
    public static $regex = '`color *: *#([a-f0-9]{3,6}) *;`isU';

    /** @var boolean modifiable */
    public static $can_modify = true;
    
    /** @var \EasyCssHexColorField */
    protected $color;

    public function __construct($id, $value)
    {        
        $this->color = new EasyCssHexColorField($id, $value);
        $this->id = $id;
    }

    public function createFormElement()
    {
        $color_tpl = $this->color->getForm(LangLoader::get_message('color_description', 'common', 'easycss'));
        $begin = new StringTemplate('<div class="easycss-field">');
        $end = new StringTemplate('</div>');
        return array($begin, $color_tpl,$end);
    }
    
    public static function constructFromPost($id, \HTTPRequestCustom $request)
    {
        $hexcolor = $request->get_poststring('EasyCssHexColorField_' . $id, false);
        return new self($id, $hexcolor);
    }

    public function getTextToFile()
    {
        return 'color : #' . $this->color->getColor() .';';
    }

}

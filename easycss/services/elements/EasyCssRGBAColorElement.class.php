<?php

/* #################################################
 *                           EasyCssRGBAColorElement.class.php
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
 * Description of EasyCssRGBAColorElement
 *
 * @author Toss
 */
class EasyCssRGBAColorElement extends EasyCssAbstractElement
{
    
    /** @var \EasyCssRGBColorField */
    protected $color;
    
    /** @var \EasyCssTransparencyField */
    protected $transparency;

    /** @var boolean modifiable */
    public static $can_modify = true;
    
    public $to_display = true;    

    
    
    public function __construct($id, $parent_id, $value)
    {
        $values = explode(',', $value);
        $rgbcolor = $values[0] . ',' . $values[1] . ',' . $values[2];
        
        $this->color = new EasyCssRGBColorField($parent_id . '/' . $id, $rgbcolor);
        $this->transparency =new EasyCssTransparencyField($parent_id . '/' . $id, $values[3]);
        $this->id = $id;
        $this->parent_id = $parent_id;
    }

    public function get_templates()
    {
        $color_tpl = $this->color->getForm(LangLoader::get_message('color_description', 'common', 'easycss'));
        $transp_tpl = $this->transparency->getForm(LangLoader::get_message('transparency_description', 'common', 'easycss'));
        $begin = new StringTemplate('<div class="easycss-field">');
        $end = new StringTemplate('</div>');
        AdminEasyCssEditController::add_field_to_hidden_input($this->parent_id . '/' . $this->id);
        return array($begin, $color_tpl,$transp_tpl, $end);
    }
    
    public static function constructFromPost($id, \HTTPRequestCustom $request)
    {
        $hexcolor = $request->get_poststring('EasyCssRGBColorField_' . $id, false);
        $transparency = $request->get_poststring('EasyCssTransparencyField_' . $id, false);
        $rgbcolor = EasyCssRGBColorField::HexToRBG($hexcolor);
        $value = $rgbcolor .',' . $transparency;
        return new self($id, $value);
    }

    public function getTextToFile()
    {
        return 'color : rgba(' . $this->color->getRGBColor() . ',' . $this->transparency->getTransparency() .');';
    }
    
    public function setValueFromPost(\HTTPRequestCustom $request)
    {
        $color_value = $request->get_poststring($this->parent_id . '/' . $this->id . get_class($this->color), false);
        $transparency_value = $request->get_poststring($this->parent_id . '/' . $this->id . get_class($this->transparency), false);
        $color_modif = $this->color->setValue($color_value);
        $transp_modif = $this->transparency->setValue($transparency_value);
        if ($color_modif !== FALSE || $transp_modif !== FALSE)
        {
            return $this->color->getRGBColor() . ',' . $this->transparency->getTransparency();
        }
        return false;
    }
    

}

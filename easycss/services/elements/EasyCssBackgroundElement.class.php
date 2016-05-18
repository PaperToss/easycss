<?php

/* #################################################
 *                           EasyCssBackgroundElement.class.php
 *                            -------------------
 *   begin                : 2016/05/18
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
 * Description of EasyCssBackgroundElement
 *
 * @author PaperToss
 */
class EasyCssBackgroundElement extends EasyCssAbstractElement
{

    public $to_display = true;

    /** @var \EasyCssHexColorField */
    protected $color;
    
    /** @var int    Type du champ color */
    protected $color_type;
    
    /** Types de champ color */
    CONST RGBA_COLOR = 1;
    CONST RGB_COLOR = 2;
    CONST HEX_COLOR = 3;
    
    /** @var string     Champs non gérés */
    protected $generic_attributes;

    /** @staticvar array Regex */
    public static $regex = [
        '`(?<=[^-])background\s*:\s*(.*)\s*;`isU',
    ];

    public function __construct($id, $parent_id, $value)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $fields = explode(' ', trim($value));
        $attributes = [];
        foreach ($fields as &$field)
        {
            if (!isset($this->color))
            {
                $this->create_color ($field);
                if (isset($this->color))
                    $field = '';
            }
            if ($field !== '') $attributes[] = $field;
        }

        $this->generic_attributes = implode(' ', $attributes);
    }

    public function get_templates()
    {
        $color_tpl = $this->color->get_form(LangLoader::get_message('background_color_description', 'common', 'easycss'));
        if ($this->color_type === self::RGBA_COLOR)
            $transp_tpl = $this->transparency->get_form(LangLoader::get_message('transparency_description', 'common', 'easycss'));
        $begin = new StringTemplate('<div class="easycss-field">');
        $end = new StringTemplate('</div>');
        AdminEasyCssEditController::add_field_to_hidden_input($this->parent_id . '/' . $this->id);
        $tpls = [$begin, $color_tpl];
        if ($this->color_type === self::RGBA_COLOR)
            array_push ($tpls, $transp_tpl);
        array_push ($tpls, $end);
        return $tpls;
    }

    public function get_text_to_file()
    {
        $str = 'background : ';
        if ($this->color_type === self::RGBA_COLOR)
            $str .= 'rgba(' . $this->color->get_color() . ',' . $this->transparency->get_transparency() .') ';
        if ($this->color_type === self::RGB_COLOR)
            $str .= 'rgb(' . $this->color->get_color() .') ';
        if ($this->color_type === self::HEX_COLOR)
            $str .= '#' . $this->color->get_color() .' ';
        
        $str .= $this->generic_attributes;
        
        return $str . ';';
    }

    public function set_value_from_post(\HTTPRequestCustom $request)
    {
        $color_value = $request->get_poststring($this->parent_id . '/' . $this->id . get_class($this->color), false);
        if ($this->color_type === self::RGBA_COLOR)
            $transparency_value = $request->get_poststring($this->parent_id . '/' . $this->id . get_class($this->transparency), false);
        $color_modif = $this->color->set_value($color_value);
        if ($this->color_type === self::RGBA_COLOR)
            $transp_modif = $this->transparency->set_value($transparency_value);
        if ($color_modif !== FALSE || (($this->color_type === self::RGBA_COLOR) && $transp_modif !== FALSE))
        {
            if ($this->color_type === self::RGBA_COLOR)
                return $this->color->get_color() . ',' . $this->transparency->get_transparency();
            return $this->color->get_color();
        }
        return false;
    }
    
    private function create_color($value)
    {
        if (substr($value, 0, 4) == 'rgba')
        {
            $this->create_rgba_color($value);
        }
        elseif (substr($value, 0, 3) == 'rgb')
        {
            $this->create_rgb_color($value);
        }
        elseif (substr($value, 0, 1) == '#')
        {
            $this->create_hex_color($value);
        }
    }
    
    private function create_rgba_color($value)
    {
        $color = substr($value,4);
        $color = str_replace(['(', ')'], '', $color);
        $values = explode(',', $color);
        $rgbcolor = $values[0] . ',' . $values[1] . ',' . $values[2];
        $this->color = new EasyCssRGBColorField($this->parent_id . '/' . $this->id, $rgbcolor);
        $this->transparency = new EasyCssTransparencyField($this->parent_id . '/' . $this->id, $values[3]);
        $this->color_type = self::RGBA_COLOR;
    }
    
    private function create_rgb_color($value)
    {
        $color = substr($value,3);
        $color = str_replace(['(', ')'], '', $color);
        $values = explode(',', $color);
        $rgbcolor = $values[0] . ',' . $values[1] . ',' . $values[2];
        $this->color = new EasyCssRGBColorField($this->parent_id . '/' . $this->id, $rgbcolor);
        $this->color_type = self::RGB_COLOR;
    }
    
    private function create_hex_color($value)
    {
        $color = substr($value,1);
        $this->color = new EasyCssHexColorField($this->parent_id . '/' . $this->id, $color);
        $this->color_type = self::HEX_COLOR;
    }

}

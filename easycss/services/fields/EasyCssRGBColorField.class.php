<?php

/* #################################################
 *                           EasyCssRGBColorField.class.php
 *                            -------------------
 *   begin                : 2016/04/29
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
 * Description of EasyCssRGBColorField
 *
 * @author Toss
 */
class EasyCssRGBColorField extends EasyCssAbstractField
{
    protected $HexColor;
    
    protected $RGBColor;
    
    public function __construct($id, $rgbcolor)
    {
        $values = explode(',', $rgbcolor);
        $this->RGBColor = $values[0] . ',' . $values[1] . ',' . $values[2];
        $r = self::RGBtoHex($values[0]);
        $g = self::RGBtoHex($values[1]);
        $b = self::RGBtoHex($values[2]);
        $this->HexColor = $r . $g . $b;
        $this->id = $id . __CLASS__;
    }
    
    public function getHexColor()
    {
        return $this->HexColor;
    }

    public function getRGBColor()
    {
        return $this->RGBColor;
    }

    public function getForm($label)
    {
        $tpl = new FileTemplate('easycss/fields/EasyCssColorField.tpl');
        $tpl->put_all(array(
            'NAME' =>$this->id,
            'ID' => $this->id,
            'HTML_ID' => $this->id,
            'VALUE' => '#' . $this->HexColor,
            'LABEL' => $label,
        ));
        return $tpl;
    }

    public function setValue($hexcolor)
    {
        $rgbcolor = self::HexToRBG($hexcolor);
        if ($this->RGBColor == $rgbcolor)
        {
            return false;
        }
        $this->RGBColor = $rgbcolor;
        if (substr($hexcolor,0,1) == '#' )
                $hexcolor = substr($hexcolor,1);
        $this->HexColor = $hexcolor;
        return $this->RGBColor;
    }
    
    public static function RGBtoHex($n)
    {
        $n = intval($n);
        if (!$n)
            return '00';

        $n = max(0, min($n, 255)); // s'assurer que 0 <= $n <= 255
        $index1 = (int) ($n - ($n % 16)) / 16;
        $index2 = (int) $n % 16;

        return substr("0123456789ABCDEF", $index1, 1)
                . substr("0123456789ABCDEF", $index2, 1);
    }

    public static function HexToRBG($hex)
    {
        $hex = str_replace("#", "", $hex);

        if (strlen($hex) == 3)
        {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else
        {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }
        $rgb = array($r, $g, $b);
        return implode(",", $rgb); 
    }
}

<?php

/* #################################################
 *                           EasyCssHexColorField.class.php
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
 * Description of EasyCssHexColorField
 *
 * @author Toss
 */
class EasyCssHexColorField
{
    protected $color;
    
    protected $id;
    
    public function __construct($id, $color)
    {
        if (substr($color,0,1) == '#' )
                $color = substr($color,1);
        $this->color = $color;
        $this->id = $id;
    }
    
    public function getColor()
    {
        return $this->color;
    }

    public function getForm($label)
    {
        $tpl = new FileTemplate('easycss/fields/EasyCssColorField.tpl');
        $tpl->put_all(array(
            'NAME' => __CLASS__ . '_' . $this->id,
            'ID' => __CLASS__ . '_' . $this->id,
            'HTML_ID' => __CLASS__ . '_' . $this->id,
            'VALUE' => '#' . $this->color,
            'LABEL' => $label,
        ));
        return $tpl;
    }

}

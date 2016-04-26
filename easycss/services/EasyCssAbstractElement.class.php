<?php

/* #################################################
 *                           EasyCssAbstractElement.class.php
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
 * Description of EasyCssAbstractElement
 *
 * @author Toss
 */
abstract class EasyCssAbstractElement
{
    /** @var string     Regex de l'élément */
    public static $regex;
    
    /** @var string     Texte à remettre dans le fichier CSS */
    public static $css_text;
    
    /** @var bool       Elément modifiable */
    public static $can_modify;
    
    protected $id, $value;
    
    public function __construct($id, $value)
    {
        $this->id = $id;
        $this->value = $value;
    }
    
    abstract public function createFormElement(\FormFieldsetHTML $fieldset);
    
    abstract public function getTextToFile();


    public static function replace($matches)
    {
        AdminEasyCssEditController::$counter++;
        $class = get_called_class();
        AdminEasyCssEditController::$vars[AdminEasyCssEditController::$counter] = new $class(AdminEasyCssEditController::$counter, $matches[1]);
        return '###' . AdminEasyCssEditController::$counter . '/###';
    }
}

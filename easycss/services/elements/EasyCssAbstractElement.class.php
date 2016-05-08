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
 * Classe abstraite permettant la factorisation des éléments
 *
 * @author PaperToss
 */
abstract class EasyCssAbstractElement
{
    /** @staticvar string     Regex de l'élément */
    public static $regex;
    
    /** @staticvar bool       Elément modifiable */
    public static $can_modify;
    
    /** @staticvar bool       Elément affiché */
    public $to_display;
    
    public $id;
    
    public $parent_id;
    
    /** @var \EasyCssAbstractElement array */
    public static $elements = array(
        'EasyCssHexColorElement' => '`(?<=[^-])color\s*:\s*#([a-f0-9]{3,6})\s*;`isU',
        'EasyCssRGBAColorElement' => '`(?<=[^-])color\s*:\s*rgba\s*\(\s*(.+)\s*\)\s*;`isU',
    );
    
    /**
     * @abstract
     * Constructeur de la classe
     * 
     * Doit stocker l'id et si nécessaire, traiter $value qui contient toutes les valeurs du champ dans le fichier CSS
     * 
     * @param string    $id     ID de remplacement
     * @param string    $value  Valeur du champ tel qu'écrit dans le fichier CSS
     */
    //abstract public function __construct(); 
    
    /**
     * @abstract
     * Texte de retour
     * Retourne le texte qui sera écrit dans le fichier CSS après modification
     * 
     * @return string Déclaration pour enregistrement dans le fichier CSS
     */
    abstract public function getTextToFile();
    
    public function getChildName()
    {
        return get_called_class();
    }
}

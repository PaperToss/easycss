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
 * Classe abstraite permettant la factorisation des �l�ments
 *
 * @author PaperToss
 */
abstract class EasyCssAbstractElement
{
    
    /** @var bool           El�ment affich� */
    public $to_display;
    
    /** @var string         ID de l'�l�ment */
    public $id;
    
    /** @var string         ID du parent direct */
    protected $parent_id;
    
    /** @var \EasyCssAbstractElement array  El�ments � parser*/
    public static $elements = array(
        'EasyCssHexColorElement' => '`(?<=[^-])color\s*:\s*#([a-f0-9]{3,6})\s*;`isU',
        'EasyCssRGBAColorElement' => '`(?<=[^-])color\s*:\s*rgba\s*\(\s*(.+)\s*\)\s*;`isU',
    );
    
    
    /**
     * @abstract
     * Texte de retour
     * Retourne le texte qui sera �crit dans le fichier CSS apr�s modification
     * 
     * @return string D�claration pour enregistrement dans le fichier CSS
     */
    abstract public function getTextToFile();
    
    public function getChildName()
    {
        return get_called_class();
    }
}

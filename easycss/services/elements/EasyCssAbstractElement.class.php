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
    
    /** @var bool           Elément affiché */
    public $to_display;
    
    /** @var string         ID de l'élément */
    public $id;
    
    /** @var string         ID du parent direct */
    protected $parent_id;
    
    /** @var \EasyCssAbstractElement array  Eléments à parser*/
    public static $elements = array(
        'EasyCssHexColorElement' => '`(?<=[^-])color\s*:\s*#([a-f0-9]{3,6})\s*;`isU',
        'EasyCssRGBAColorElement' => '`(?<=[^-])color\s*:\s*rgba\s*\(\s*(.+)\s*\)\s*;`isU',
    );
    
    
    /**
     * @abstract
     * Texte de retour
     * Retourne le texte qui sera écrit dans le fichier CSS après modification
     * 
     * @return string Déclaration pour enregistrement dans le fichier CSS
     */
    abstract public function get_text_to_file();
    
    /**
     * @abstract
     * Templates à afficher
     * Retourne les templates des différents fields qui compose l'élément
     * 
     * @return \FileTemplate Template ou tableau de templates
     */
    abstract public function get_templates();
    
    /**
     * Retourne le nom de la classe de l'élément
     * 
     * @return string   Nom de la classe de l'élément
     */
    public function get_child_name()
    {
        return get_called_class();
    }
}

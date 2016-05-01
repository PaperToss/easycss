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
    /** @staticvar string     Regex de l'�l�ment */
    public static $regex;
    
    /** @staticvar bool       El�ment modifiable */
    public static $can_modify;
    
    protected $id;
    
    /**
     * @abstract
     * Constructeur de la classe
     * 
     * Doit stocker l'id et si n�cessaire, traiter $value qui contient toutes les valeurs du champ dans le fichier CSS
     * 
     * @param string    $id     ID de remplacement
     * @param string    $value  Valeur du champ tel qu'�crit dans le fichier CSS
     */
    abstract public function __construct($id, $value);
    
    /**
     * @abstract
     * Texte de retour
     * Retourne le texte qui sera �crit dans le fichier CSS apr�s modification
     * 
     * @return string D�claration pour enregistrement dans le fichier CSS
     */
    abstract public function getTextToFile();
    
    /**
     * @abstract
     * @static
     * Constructeur depuis le POST
     * Cr�� une instance de cette m�me classe en allant r�cup�rer les param�tres POST
     * 
     * @param   string                  $id ID de remplacement qui permettra d'aller r�cup�rer les param�tres POST
     * @param   \HTTPRequestCustom      $request Fournit l'acc�s aux param�tres HTTP
     * @return  \EasyCssAbstractElement Instance de cette m�me classe
     */
    abstract public static function constructFromPost($id, \HTTPRequestCustom $request);

    /**
     * @final
     * @static
     * Fonction de remplacement lors du parsage
     * Fonction qui sera ex�cut�e lors du preg_replace_callback pour rep�rer les champs � inclure � l'affichage
     * 
     * @param array $matches    R�sultats de recherche du preg_replace_callback
     * @return string           Texte de remplacement
     */
    final public static function replace($matches)
    {
        AdminEasyCssEditController::$counter++;
        $class = get_called_class();
        
        AdminEasyCssEditController::$vars[AdminEasyCssEditController::$counter] = new $class(AdminEasyCssEditController::$counter, $matches[1]);
        return '###' . AdminEasyCssEditController::$counter . '/###';
    }
    
}

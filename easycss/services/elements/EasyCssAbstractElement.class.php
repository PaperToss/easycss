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
    
    protected $id;
    
    /**
     * @abstract
     * Constructeur de la classe
     * 
     * Doit stocker l'id et si nécessaire, traiter $value qui contient toutes les valeurs du champ dans le fichier CSS
     * 
     * @param string    $id     ID de remplacement
     * @param string    $value  Valeur du champ tel qu'écrit dans le fichier CSS
     */
    abstract public function __construct($id, $value);
    
    /**
     * @abstract
     * Texte de retour
     * Retourne le texte qui sera écrit dans le fichier CSS après modification
     * 
     * @return string Déclaration pour enregistrement dans le fichier CSS
     */
    abstract public function getTextToFile();
    
    /**
     * @abstract
     * @static
     * Constructeur depuis le POST
     * Créé une instance de cette même classe en allant récupérer les paramètres POST
     * 
     * @param   string                  $id ID de remplacement qui permettra d'aller récupérer les paramètres POST
     * @param   \HTTPRequestCustom      $request Fournit l'accès aux paramètres HTTP
     * @return  \EasyCssAbstractElement Instance de cette même classe
     */
    abstract public static function constructFromPost($id, \HTTPRequestCustom $request);

    /**
     * @final
     * @static
     * Fonction de remplacement lors du parsage
     * Fonction qui sera exécutée lors du preg_replace_callback pour repérer les champs à inclure à l'affichage
     * 
     * @param array $matches    Résultats de recherche du preg_replace_callback
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

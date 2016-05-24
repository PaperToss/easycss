<?php

/* #################################################
 *                           EasyCssAbstractAttribut.class.php
 *                            -------------------
 *   begin                : 2016/05/20
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
 * Description of EasyCssAbstractAttribut
 *
 * @author Toss
 */
abstract class EasyCssAbstractAttribut
{
    protected $id;
    
    protected $parent_id;
    
    protected $raw_value;
    
    
    protected $values = [];

    protected $is_important = false;
    
    public $on_error = false;
    
    protected $begin_block = '<div class="easycss-field">';
    
    protected $end_block = '</div>';
    
    public $to_display = true;
    
    protected $elements;
    
    protected $separator = ' ';
    
    /** @var \EasyCssAbstractAttribut array  Attributs à parser*/
    public static $attributs = [
        'EasyCssColorAttribut',
    ];
    
    /** @staticvar array Regex */
    public static $regex = [];

    protected function __construct($id, $parent_id, $value)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->raw_value = $value;
        $this->check_important();
        $this->explode_elements();
    }
    
    protected function add_error($attribut, $msg)
    {
        $tpl = new StringTemplate('<div>' . $attribut . ' : ' . $msg . '</div>');
        AdminEasyCssEditController::add_error($tpl);
        $this->on_error = true;
    }
    
    /**
     * Templates à afficher
     * Retourne les templates des différents fields qui compose l'élément
     * 
     * @return \FileTemplate Template ou tableau de templates
     */
    public function get_templates($tpl, $label = false)
    {
        
        if (!is_array($tpl))
            $tpls[] = $tpl;
        else
            $tpls = $tpl;
        
        $begin_tpl = new StringTemplate($this->begin_block);
        $end_tpl = new StringTemplate($this->end_block);
        if ($label !== false)
        {
            $label_tpl = new StringTemplate('<h6>' . $label . '</h6>');
            array_unshift($tpls, $label_tpl);
        }
        array_unshift($tpls, $begin_tpl);
        array_push($tpls, $end_tpl);
        return $tpls;
    }
    
    /**
     * @abstract
     * Texte de retour
     * Retourne le texte qui sera écrit dans le fichier CSS après modification
     * 
     * @return string Déclaration pour enregistrement dans le fichier CSS
     */
    abstract public function get_text_to_file();
    
    
    /**
     * Retourne le nom de la classe de l'élément
     * 
     * @return string   Nom de la classe de l'élément
     */
    public function get_child_name()
    {
        return get_called_class();
    }
    
    private function check_important()
    {
        $pos = strpos($this->raw_value, '!important');
        if ($pos !== false)
        {
            $this->raw_value = str_replace('!important', '', $this->raw_value);
            $this->is_important = true;
        }
    }
    
    private function explode_elements()
    {
        if ($this->separator === false)
        {
            $this->values[] = trim($this->raw_value);
            return;
        }
        $this->values = explode($this->separator, trim($this->raw_value));
    }
}

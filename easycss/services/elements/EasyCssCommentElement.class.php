<?php

/* #################################################
 *                           EasyCssCommentElement.class.php
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
 * Description of EasyCssCommentElement
 *
 * @author Toss
 */
class EasyCssCommentElement extends EasyCssAbstractElement
{

    /** Titre de la forme /** Commentaire */ /**/
    public static $regex = '`\/\*\*\s*(.+)\s*\*\/`isU';

    /** @var boolean Non modifiable */
    public static $can_modify = false;
    
    /** @var \EasyCssCommentField */
    protected $title;

    public function __construct($id, $title)
    {
        $this->title = new EasyCssCommentField($id, $title);
        $this->id = $id;
    }

    public function createFormElement()
    {
        $title_tpl = $this->title->getForm(false);
        return array($title_tpl);
    }
    
    public static function constructFromPost($id, \HTTPRequestCustom $request)
    {
        return false;
    }

    public function getTextToFile()
    {
        return '/** ' . $this->title->getComment() . ' */';
    }

}

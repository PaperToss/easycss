<?php

/* #################################################
 *                           EasyCssMainBlock.class.php
 *                            -------------------
 *   begin                : 2016/05/03
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
 * Description of EasyCssMainBlock
 *
 * @author PaperToss
 */
class EasyCssMainBlock extends EasyCssAbstractBlock
{

    public function __construct($css_content)
    {
        $this->id = 'main';
        $this->parent_id = '';
        $this->css_content = $css_content;
        $this->parse_blocks_content();
    }

    protected function parse_blocks_content()
    {
        $css = $this->parse_media_block($this->css_content);
        $css = $this->parse_block($css);
        $css = $this->parse_title_block($css);
        $css = $this->parse_display_comment_block($css);
        $css = $this->parse_comment_block($css);


        $this->parsed_css = str_replace('}', '', $css);
    }

    public function replace_with_post($post_elements, \HTTPRequestCustom $request)
    {
        $elements = explode(';', $post_elements);
        foreach ($elements as $element)
        {
            if ($element == '')
                break 1;
            $path = explode('/', $element);
            
            array_shift($path);
            array_shift($path);
            $path = implode('/', $path);
            $modif = $this->setValueFromPost($path, $request);
            if ($modif !== false)
            {
                echo $this->getChildFullName($element) . ' est modifié ' . $modif . "<br/>";
            }
        }
    }

    protected function getChildFullName($path)
    {
        $path = explode('/', $path);

        array_shift($path);
        array_shift($path);
        $path = implode('/', $path);
        return $this->getChildName($path);
    }

    protected function getChildName($path_child)
    {
        $path = explode('/', $path_child);
        $child = $path[0];
        array_shift($path);
        $path = implode('/', $path);
        return '/main/' . $this->children[$child]->GetChildName($path);
    }

}

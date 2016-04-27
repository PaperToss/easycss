<?php

/* #################################################
 *                           AdminEasyCssEditController.class.php
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
 * Description of AdminEasyCssEditController
 *
 * @author Toss
 */
class AdminEasyCssEditController extends ModuleController
{

    /** @var \FileTemplate  Vue */
    private $view;

    /** @var array          Array de langue */
    private $lang;

    /** @var \HTMLForm      Formulaire */
    private $form;

    /** @var \FormFieldsetHTML      Contenant des champs */
    private $fieldset;

    /** @var \File          Fichier CSS chargé */
    private $file;

    /** @var string         Nom du thème */
    private $theme_id;

    /** @var string         Nom du fichier css */
    private $css_id;

    /** @var int            Compteur de remplacement */
    public static $counter;

    /** @var array          Elements remplacés */
    public static $vars;

    /** @var string         Contenu du fichier parsé */
    private $parsed_content;

    /** @var \EasyCssAbstractElement array */
    private $elements = ['EasyCssTitleElement', 'EasyCssColorElement'];

    public function execute(\HTTPRequestCustom $request)
    {
        $this->get_file($request);
        $this->init();

        $this->build_form();
        $this->do_preg_replace();

        $this->fieldset = new FormFieldsetHTML($this->theme_id, $this->theme_id . ' - ' . $this->css_id);
        $this->form->add_fieldset($this->fieldset);

        if ($request->is_post_method())
            $this->post_process($request);

        $this->build_elements_to_display();

        $this->finalize_form();

        return $this->build_response($this->view);
    }

    private function init()
    {
        $this->lang = LangLoader::get('common', 'easycss');
        $this->view = new StringTemplate('# INCLUDE MSG # # INCLUDE FORM #');
        $this->view->add_lang($this->lang);
    }

    private function get_file(\HTTPRequestCustom $request)
    {
        $this->theme_id = $request->get_getstring('theme', false);
        $this->theme_id = trim($this->theme_id, '/');

        $this->css_id = $request->get_getstring('file', false);
        $this->css_id = trim($this->css_id, '/');

        $file_path = PATH_TO_ROOT . '/templates/' . $this->theme_id . '/theme/' . $this->css_id . '.css';
        $this->file = new File($file_path);

        if (!$this->file->exists())
            DispatchManager::redirect(PHPBoostErrors::unexisting_page());
    }

    private function build_form()
    {
        $form = new HTMLForm(__CLASS__);
        $this->form = $form;
    }

    private function finalize_form()
    {
        $button = new FormButtonDefaultSubmit();
        $this->form->add_button($button);
        $this->form->add_button(new FormButtonReset());
        $this->view->put('FORM', $this->form->display());
    }

    private function build_response(View $view)
    {
        $response = new AdminDisplayResponse($view);
        $response->get_graphical_environment()->set_page_title($this->lang['module_title']);
        return $response;
    }

    private function do_preg_replace()
    {
        $this->parsed_content = $this->file->read();

        foreach ($this->elements as $element)
        {
            $this->parsed_content = preg_replace_callback($element::$regex, array($element, 'replace'), $this->parsed_content);
        }
    }

    private function post_process(\HTTPRequestCustom $request)
    {
        $post_elements = $request->get_poststring(__CLASS__ . '_elements', false);
        $elements = explode('-', $post_elements);
        foreach ($elements as $element)
        {
            if ($element == '')
                break 1;
            $exploded_element = explode('_', $element);
            $classname = $exploded_element[0];
            $id = $exploded_element[1];
            $value = $request->get_poststring(__CLASS__ . '_' . $element, false);
            if ($classname::$can_modify)
                self::$vars[$id] = new $classname($id, $value);
        }
        $this->write_to_file();
        $this->view->put('MSG', MessageHelper::display($this->lang['file_edit_success'], MessageHelper::SUCCESS, 5));
    }

    private function write_to_file()
    {
        $lines = explode("\n", $this->parsed_content);
        $css = '';
        foreach ($lines as &$line)
        {
            $line = preg_replace_callback('`###(\d+)\/###`isU', function($matches)
            {
                $obj = self::$vars[$matches[1]];
                return $obj->getTextToFile();
            }, $line);
            $css .= $line . "\n";
        }
        $this->file->write($css);
    }
    
    private function build_elements_to_display()
    {
        $textarea_content = '';

        $lines = explode("\n", $this->parsed_content);

        foreach ($lines as $line)
        {
            if (preg_match('`###(\d+)\/###`isU', $line, $matches))
            {
                $obj = self::$vars[$matches[1]];
                $this->fieldset = $obj->createFormElement($this->fieldset);

                $textarea_content .= get_class($obj) . '_' . $matches[1] . '-';
            }
        }
        $textarea = new FormFieldHidden('elements', $textarea_content);
        $this->fieldset->add_field($textarea);
    }

}

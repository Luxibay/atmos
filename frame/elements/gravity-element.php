<?php

class GravityElement extends OxyEl
{

    function init()
    {
    }

    function afterInit()
    {
    }

    function name()
    {
        return 'Gravity';
    }

    function slug()
    {
        return 'gravity';
    }

    function icon()
    {
        return plugin_dir_url(__FILE__) . '/assets/gravity-element-logo.svg';
    }

    function button_place()
    {
        return "helpers::interactive";

    }

    function button_priority()
    {
    }


    function render($options, $defaults, $content)
    {
        if (did_action('wp_head') != 1) {
            if (class_exists('GFFormDisplay')) {
                GFFormDisplay::print_form_scripts(intval($options['form_add_id']) ?? 0, $options['form_ajax'] ?? false);
            }
        } else {
            gravity_form_enqueue_scripts($options['form_add_id'], $options['form_ajax'] ?? false);
        }
        gravity_form($options['form_add_id'], $options['form_show_title'] ?? true, $options['form_show_description'] ?? true, $options['form_show_inactive'] ?? false, '', $options['form_ajax'] ?? false, $options['form_tabindex'] ?? 0);

    }


    function controls()
    {

        $controlSection = $this->addControlSection("form_information", __("Form Settings"), "assets/icon.png", $this);

        $form_selection = $this->addOptionControl(
            array(
                "type" => 'dropdown',
                "name" => 'Form Selection',
                "slug" => 'form_add_id'
            )
        );

        $form_list = GFAPI::get_forms($active = true, $trash = false, $sort_column = 'title', $sort_dir = 'ASC');

        $form_array = array();
        foreach ($form_list as $form) {
            $form_array[$form['id']] = $form['title'];
        }


        $form_selection->setValue(
            $form_array
        );

        $form_title = $controlSection->addOptionControl(
            array(
                "type" => 'buttons-list',
                "name" => 'Include Form Title',
                "slug" => 'form_show_title'
            )
        );

        $form_title->setValue(
            array(
                true => 'Show',
                false => 'Hide'
            )
        );

        $form_title->setDefaultValue(true);

        $form_description = $controlSection->addOptionControl(
            array(
                "type" => 'buttons-list',
                "name" => 'Include Form Description',
                "slug" => 'form_show_description'
            )
        );

        $form_description->setValue(
            array(
                true => 'Show',
                false => 'Hide'
            )
        );

        $form_description->setDefaultValue(true);

        $form_inactive = $controlSection->addOptionControl(
            array(
                "type" => 'buttons-list',
                "name" => 'Show Inactive Form',
                "slug" => 'form_show_inactive'
            )
        );

        $form_inactive->setValue(
            array(
                true => 'Show',
                false => 'Hide'
            )
        );

        $form_inactive->setDefaultValue(false);

        $form_ajax = $controlSection->addOptionControl(
            array(
                "type" => 'buttons-list',
                "name" => 'AJAX Submission',
                "slug" => 'form_ajax'
            )
        );

        $form_ajax->setValue(
            array(
                true => 'Enable',
                false => 'Disable'
            )
        );

        $form_ajax->setDefaultValue(false);

        $form_tabindex = $controlSection->addOptionControl(
            array(
                "type" => 'measurebox',
                "name" => 'Starting Tab Index',
                "slug" => 'form_tabindex'
            )
        );

        $form_tabindex->setDefaultValue(0);
    }

    function defaultCSS()
    {

        return file_get_contents(__DIR__ . '/' . basename(__FILE__, '.php') . '.css');

    }

}

new GravityElement();
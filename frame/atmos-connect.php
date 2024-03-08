<?php

class Atmos_Connect
{
    private $atmos_stop = false;

    public function __construct()
    {

        $this->atmos_admin_callback();

        $this->atmos_dependencies_check();

        /* Hook up if everything is active...*/
        if ($this->atmos_stop == false) {
            add_action('atmos_integrate', array($this, 'atmos_integrate_callback'), 10, 2);
            do_action('atmos_integrate');
        }
    }

    function atmos_dependencies_check()
    {
        if (!isset($atmos_notices)) {
            $atmos_notices = new WPTRT\AdminNotices\Notices();
        }

        /* Check for Gravity Forms */
        if (!class_exists('GFForms')) {
            $this->atmos_stop = true;
            $atmos_notices->add(
                'atmos_gravity',
                '',
                __(ATMOS_NAME . ' requires the Gravity Forms plugin to be installed and activated to work correctly. ', 'atmos'),
                [
                    'type' => 'warning',

                ]
            );
        }



        /* Check for Oxygen */
        if (!class_exists('OxygenElement')) {
            $this->atmos_stop = true;
            $atmos_notices->add(
                'atmos_oxygen',
                '',
                __(ATMOS_NAME . ' requires the Oxygen Builder plugin to be installed and activated to work correctly.', 'atmos'),
                [
                    'type' => 'warning',
                ]
            );
        }

        $atmos_notices->boot();
    }

    function atmos_admin_callback()
    {
        /* Load Admin features */
        foreach (glob(ATMOS_PATH . "/admin/*.php") as $filename) {
            include $filename;
        }

        /* Include Notices */
        foreach (glob(ATMOS_PATH . "/admin/wptrt/admin-notices/src/*.php") as $filename) {
            include $filename;
        }
    }

    function atmos_integrate_callback()
    {

        /* Integrate the plugins */
        foreach (glob(ATMOS_PATH . "/includes/*.php") as $file) {
            require $file;
        }

        foreach (glob(ATMOS_PATH . "/elements/*.php") as $filename) {
            include $filename;
        }
    }
}

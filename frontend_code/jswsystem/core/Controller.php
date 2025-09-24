<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 * @package     CodeIgniter
 * @subpackage  Libraries
 * @category    Libraries
 */

/**
 * CodeIgniter Application Controller Class
 *
 * Superclass for all controllers.
 */
#[\AllowDynamicProperties] // extra safety for any missed properties
class CI_Controller
{
    private static $instance;

    // Declare commonly-assigned properties to avoid PHP 8.2+ dynamic property deprecations
    public $load;
    public $config;
    public $uri;
    public $router;
    public $benchmark;
    public $hooks;
    public $input;
    public $lang;
    public $output;
    public $security;

    // DB-related (assigned by Loader::database/dbforge/dbutil)
    public $db = null;
    public $dbforge = null;
    public $dbutil = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        self::$instance =& $this;

        // Assign all base classes instantiated by CodeIgniter.php
        foreach (is_loaded() as $var => $class)
        {
            $this->$var =& load_class($class);
        }

        // Loader
        $this->load =& load_class('Loader', 'core');
        $this->load->initialize();

        log_message('debug', 'Controller Class Initialized');
    }

    /**
     * Get CI super object instance
     * @return CI_Controller
     */
    public static function &get_instance()
    {
        return self::$instance;
    }
}
// END Controller class

/* End of file Controller.php */
/* Location: ./system/core/Controller.php */

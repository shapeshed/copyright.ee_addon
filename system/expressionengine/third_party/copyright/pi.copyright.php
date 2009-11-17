<?php
/** 
 * ExpressionEngine
 *
 * LICENSE
 *
 * ExpressionEngine by EllisLab is copyrighted software
 * The licence agreement is available here http://expressionengine.com/docs/license.html
 * 
 * Copyright
 * 
 * @category   Plugins
 * @package    Copyright
 * @version    1.0.0
 * @since      1.0.0
 * @author     George Ornbo <george@shapeshed.com>
 * @see        {@link http://github.com/shapeshed/copyright.ee_addon/} 
 * @license    {@link http://opensource.org/licenses/bsd-license.php} 
 */

/**
* Plugin information used by ExpressionEngine
* @global array $plugin_info
*/
$plugin_info = array(
  'pi_name'         => 'Copyright',
  'pi_version'      => '1.0.0',
  'pi_author'       => 'George Ornbo',
  'pi_author_url'   => 'http://shapeshed.com/',
  'pi_description'  => 'Prints a copyright notice',
  'pi_usage'        => Copyright::usage()
  );

class Copyright{

  /**
  * Data sent back to calling function
  * @access public
  * @var string
  */
  public $return_data = "";

  /**
  * The start year for the notice. 
  * Set to a default of the current year in __construct
  * @access public
  * @see __construct
  * @var string
  */	
  public $start_year = "";
  
  /**
  * The end year for the notice. 
  * Set to a default of the current year in __construct
  * @access public
  * @see __construct
  * @var string
  */	
  public $end_year = "";
  
  /**
  * The delimiter for the two years
  * Set to a default of the "-" in __construct
  * @access public
  * @see __construct
  * @var string
  */	
  public $delimiter = "";

  /**
  * The copyright symbol
  * Set to a default of the "&copy;" in __construct
  * @access public
  * @see __construct
  * @var string
  */	
  public $copyright_symbol = "";

  /**
  * Error message is start date is after end date
  * @access public
  * @see show()
  * @var string
  */	
  public $error_message = "Start date is after end date. Please check your settings.";
  
  /**
  * ExpressionEngine needs this as it is PHP4 based so doesn't get __construct()
  * @access public
  */
  public function Unit_converter()
  {
    $this->__construct();
  }

  /**
  * Constructor. Fetches template data using the Template class
  * Sets defaults if nothing is specified in templates
  * @access public
  */
  public function __construct()
  {
    $this->EE =& get_instance();
    
    $this->start_year = ( ! $this->EE->TMPL->fetch_param('start_year')) ? date("Y") :  $this->EE->TMPL->fetch_param('start_year');
    $this->end_year = ( ! $this->EE->TMPL->fetch_param('end_year')) ? date("Y") :  $this->EE->TMPL->fetch_param('end_year');
    $this->delimiter = ( ! $this->EE->TMPL->fetch_param('delimiter')) ? "&ndash;" :  $this->EE->TMPL->fetch_param('delimiter');
    $this->copyright_symbol = ( ! $this->EE->TMPL->fetch_param('copyright_symbol')) ? "&copy;" :  $this->EE->TMPL->fetch_param('copyright_symbol');
  }

 
  /**
  * Shows the copyright notice
  * The function evaluates the dates and returns a string for display in templates
  * @access	public
  * @return   string 
  */
  public function show() 
  {
    
    if ($this->start_year == $this->end_year)
    {
      $this->return_data = $this->copyright_symbol .' '. $this->start_year;
    }
      elseif ($this->start_year < $this->end_year)
    {
      $this->return_data = $this->copyright_symbol .' '. $this->start_year . $this->delimiter . $this->end_year;
    }
    elseif ($this->start_year > $this->end_year)
    {
      $this->return_data = $this->error_message;
    }
    else
    {
      return false;
    }

  return $this->return_data;

  }

  /**
  * Plugin usage documentation
  *
  * @return	string Plugin usage instructions
  */
  public function usage()
  {
    return "Documentation is available here http://shapeshed.github.com/expressionengine/plugins/copyright/";
  }

}

?>
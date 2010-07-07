<?php

  /**
   * Copied directly from Cash Costello's errorlog v1.0. I only added a plugin setting
   * to allow the full path to the logfile to be set.
   * 
   * -------------------------------------------------------------------------------------
   * 
   * Redirect error logging to a file for those who do not have access to 
   * their server's error logs.
   *
   * Notes:
   * 1. This will create large log files if enabled for a long time or on a
   *    a large site. In that case, a cron job should be setup for log rotation.
   *
   * 2. This will not capture the Elgg debug statements when their trace level
   *    is set to debug. They send those directly to the server log.
   *
   * 3. To add debug statements in your php code and have them go to this log
   *    file, use a line like this:
   *        trigger_error("my debug message here");
   * 
   * 4. This may interfere with the error handling for the REST API. At this
   *    point in time, this API is rarely used and any interference appears to 
   *    be minor.
   *
   * 5. Want to debug a plugin that gave you a white screen, try setting
   *    php_value display_errors 1 in your .htaccess file.
   **/
  
    function mt_errorlog_init() 
    {
      set_error_handler('mt_errorlog_php_error_handler');
      set_exception_handler('mt_errorlog_php_exception_handler');
    }
    
    function mt_errorlog_php_error_handler($errno, $errstr, $errfile, $errline, $errcontext) 
    {
      global $CONFIG;
      
      // grab path to error file from plugin settings
      $errorlog = get_plugin_setting('path_to_errorlog', 'mt_errorlog');
      
      // check if plugin setting is set and if file already exists
      if (isset($errorlog)) {
          
          // check if path is not a dir and is writable
          if (!is_dir($errorlog) && is_writable($errorlog)) {
              // OK
          } else {
              // use datadir
              $errorlog = $CONFIG->datadir . '/errorlog.txt';
          }
          
      } else {
          
          // use datadir
          $errorlog = $CONFIG->datadir . '/errorlog.txt';
      }

    
      // text to spit out to errorlog
      $error = date("Y-m-d H:i:s (T)") . ": \"" . $errstr . "\" in file " . $errfile . " (line " . $errline . ")";
      
      switch ($errno) {
        case E_USER_ERROR:
            error_log("ERROR: " . $error . "\n", 3, $errorlog);
            register_error("ERROR: " . $error);
            
            // fatal error, so stop now with exception
            throw new Exception($error); 
          break;

        case E_WARNING:
        case E_USER_WARNING: 
            error_log("WARNING: " . $error . "\n", 3, $errorlog);
          break;
          
        case E_USER_NOTICE:
            error_log("DEBUG: " . $error . "\n", 3, $errorlog);
          break;

        default:
          break;
      }
      
      return true;
    }
    
    /**
     * 
     * @param $exception
     */
    function mt_errorlog_php_exception_handler($exception)
    {
      error_log("*** FATAL EXCEPTION *** : " . $exception . "\n", 3, "../../error_log.txt");
      
      $body = elgg_view("messages/exceptions/exception",array('object' => $exception));
      echo page_draw(elgg_echo('exception:title'), $body);      
    }

    
    register_elgg_event_handler('init','system','mt_errorlog_init');       
?>

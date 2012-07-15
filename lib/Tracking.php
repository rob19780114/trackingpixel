<?php 
/**
 * @author Robert Heine <rob@zcore.org>
 */

/**
 * class for logging, setting header information and
 * returning some 1x1 pixel image
 */
class Tracking {
    
    /**
     * Output file types
     */
    const TYPE_GIF = 0;
    const TYPE_PNG = 1;
    
    /**
     * pixels
     */
    const PIXEL_GIF =
"R0lGODlhAQABAIAAAP///////yH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==";
    const PIXEL_PNG = 
"iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/
oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9wHDhciLQDTcncAAAAZdEVYdENvbW1lbnQA
Q3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAADUlEQVQI12NgYGBgAAAABQABXvMqOgAAAABJRU5ErkJggg==";

    /**
     * Init class using TYPE_* constant
     * @param $type see output file types
     */
    public function __construct($type = self::TYPE_GIF) {
        if (in_array($type,array(self::TYPE_GIF, self::TYPE_PNG))) {
            $this->type = $type;
        } else {
            error_log('Unknown type, please use class constants.');
        }
    }
    
    /**
     * Returns the pixel and log provided string
     * @param $log string to log
     */
    public function getPixel($log = NULL) {
        // pixel to return
        $pixel = '';
        // call logger
        if ($log) {
            $this->log($log);
        }
        // fill header information
        $this->setHeaders();
        // fill pixel content
        if (self::TYPE_PNG == $this->type) {
            $pixel = self::PIXEL_PNG;
        } elseif (self::TYPE_GIF == $this->type) {
            $pixel = self::PIXEL_GIF;
        }
        return base64_decode($pixel);
    }
    
    /**
     * Saves the tracking information somewhere
     * @param $log track somewhere
     */
    protected function log($log) {
        // here goes your own logging class
        error_log(time() . ' : ' . $log);
    }
    
    protected function setHeaders() {
        // set standard headers
        header('Cache-Control: no-cache');
        
        // msie, p3p
        if (strstr($_SERVER["HTTP_USER_AGENT"], "MSIE")) {
            header('P3P: CP="NOI DSP CURa ADMa DEVa TAIa OUR BUS IND UNI COM NAV INT"');
        }
        
        // set length, based on type (use strlen() for custom types)
        if (self::TYPE_PNG == $this->type) {
            header('Content-type: image/png');
            header('Content-length: 242');
        } else if (self::TYPE_GIF == $this->type) {
            header('Content-type: image/gif');
            header('Content-length: 60');
        }
    }
}

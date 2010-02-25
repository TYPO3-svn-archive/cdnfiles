<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once t3lib_extMgm::extPath('cdnfiles').'class.tx_cdnfiles_specialconfiguration.php';
/**
 * Description of classtx_cdnfiles
 *
 * @author falcifer
 */
class tx_cdnfiles {
    
    /** @var $extConfig array holds the extension configuration */
    private $extConfig = array();

    /** @var $currentDirectory string with current replacement directory, cause
     * I dont know how to pass more arguments to the callback function
     */
    private $currentDirectory ='';

    private $specialConfigurationObj = null;

    public function __construct(){
        // global extension configuration
        $this->extConfig = unserialize(
            $GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['cdnfiles']
        );
        // file with absolute path
        $this->extConfig['advancedconfig_file'] = PATH_site.$this->extConfig['advancedconfig_file'];

        // the manager with advanced configuration
        $this->specialConfigurationObj = t3lib_div::makeInstance("tx_cdnfiles_specialconfiguration",$this->extConfig['advancedconfig_file']);
    }

    public function doReplacement($content){

        if ($this->extConfig['replace_fileadmin_directory']){
            $this->currentDirectory='fileadmin';
            $pattern = $this->extConfig['fileadmin_regexp'];
            $pattern = '|"'.$pattern.'"|i';
            $content = preg_replace_callback($pattern, array( &$this, 'callbackReplacementFunction'), $content);
        }
        if ($this->extConfig['replace_uploads_directory']){
            $this->currentDirectory='uploads';
            $pattern = $this->extConfig['uploads_regexp'];
            $pattern = '|"'.$pattern.'"|i';
            $content = preg_replace_callback($pattern, array( &$this, 'callbackReplacementFunction'), $content);
        }
        if ($this->extConfig['replace_typo3temppics_directory']){
            $this->currentDirectory='typo3temppics';
            $pattern = $this->extConfig['typo3temppics_regexp'];
            $pattern = '|"'.$pattern.'"|i';
            $content = preg_replace_callback($pattern, array( &$this, 'callbackReplacementFunction'), $content);
        }
        return $content;

    }
    
    private function callbackReplacementFunction($text){
            // If you have a regular expression with () then use the first () variable
            if(isset($text[1])){
                $searchedFile = $text[1];
            }else{
                $searchedFile = $text[0];
            }

            //Look for a special configuration for this file
            $file = $this->specialConfigurationObj->getFile($searchedFile);

            if ($file == $text[1] || $file == '' ){
                //If no have any special configuration just apply the common config
                switch($this->currentDirectory){
                    case 'fileadmin':                       
                        $file = $this->extConfig['fileadmin_urlprefix'] . $searchedFile;
                        break;
                    case 'uploads':                       
                        $file = $this->extConfig['uploads_urlprefix'] . $searchedFile;
                        break;
                    case 'typo3temppics':                     
                        $file = $this->extConfig['typo3temppics_urlprefix'] . $searchedFile;
                        break;

                }
            }

            //should i replace the fileadmin/ uploads/ or typo3temp/ directory
            if($this->extConfig['remove_fileadmin_directory']){
                            $file = str_replace('/fileadmin/', '/', $file);
            }
            if($this->extConfig['remove_uploads_directory']){
                            $file = str_replace('/uploads/', '/', $file);
            }
            if($this->extConfig['remove_typo3temp_directory']){
                            $file = str_replace('/typo3temp/', '/', $file);
            }

            return '"'.$file.'"';

    }
    /**
     * Just a wrapper for the main function! It's used for the contentPostProc-output hook.
     *
     * This hook is executed if the page contains *_INT objects! It's called always at the
     * last hook before the final output. This isn't the case if you are using a
     * static file cache like nc_staticfilecache.
     *
     * @return bool
     */
    public function contentPostProcOutput($_params,$pObj) {

        $ret = $this->doReplacement($pObj->content);
        if ($ret){
            $pObj->content = $ret;
            return true;
        }else{
            return false;
        }
    }


    /**
     * Just a wrapper for the main function!  It's used for the contentPostProc-all hook.
     *
     * The hook is only executed if the page doesn't contains any *_INT objects. It's called
     * always if the page wasn't cached or for the first hit!
     *
     * @return bool
     */
    public function contentPostProcAll($_params,$pObj) {

        $ret = $this->doReplacement($pObj->content);
        if ($ret){
            $pObj->content = $ret;
            return true;
        }else{
            return false;
        }
    }
}
?>

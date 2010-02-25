<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once(PATH_t3lib . 'interfaces/interface.t3lib_singleton.php');
require_once t3lib_extMgm::extPath('cdnfiles').'lib/sfYaml.php';

/**
 * Description of classtx_cdnfiles_configfile
 *
 * @author falcifer
 */
class tx_cdnfiles_specialconfiguration implements t3lib_Singleton {

    private $config = array();
    public function __construct($configFile){
        try{
            $this->config = sfYaml::load($configFile);
        }catch(InvalidArgumentException $e){
            t3lib_div::devLog($e->getMessage(),"cdnfiles");
        }

    }

    public function getFile($originalFile){
        
        //lets look in the files section
        foreach ($this->config['files'] as $file => $fileConfig){
            if(preg_match("|".$file."|i", $originalFile)){
                if($fileConfig['replace']){
                    return $fileConfig['cdn_url'];
                }else{
                    return $originalFile;
                }

            }
        }


        //lets look in the patterns section
        foreach ($this->config['patterns'] as $pattern => $patternConfig){
            if(preg_match("|".$pattern."|i", $originalFile)){
                if($patternConfig['replace']){
                    return $patternConfig['cdn_prefix'].$originalFile;
                }else{
                    return $originalFile;
                }

            }
        }
        
    }
}

?>

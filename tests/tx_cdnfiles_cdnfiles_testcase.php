<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of tx_cdnfiles_cdnfiles
 *
 * @author falcifer
 */
class tx_cdnfiles_cdnfiles_testcase extends tx_phpunit_testcase {
    public function setUp(){
        include_once(t3lib_extMgm::extPath('cdnfiles').'class.tx_cdnfiles.php');
        $this->cdnfilesObj = t3lib_div::makeInstance('tx_cdnfiles');
        
    }

    //put your code here
    public  function test_doReplacement(){

    }

    /**
     * Test the private method callbackReplacementFunction (requires PHP >= 5.3.2)
     * @dataProvider providerFiles
     */
    public function test_callbackReplacementFunction($input,$output){
        $method = new ReflectionMethod('tx_cdnfiles', 'callbackReplacementFunction');
        $method->setAccessible(TRUE);
        $this->assertEquals(
                $output,$method->invoke($this->cdnfilesObj,array($input))
                );
        
    }

    public function providerFiles(){

        return array(
          array('','""'),
          array('typo3temp/pics/d58a9b6619.jpg','"typo3temp/pics/d58a9b6619.jpg"'),

        );
    }
}
?>

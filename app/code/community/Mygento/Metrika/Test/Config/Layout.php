<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Test_Config_Layout extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * @test
     */
    public function testFrontendLayout()
    {
        $this->assertLayoutFileDefined('frontend', 'mygento/metrika.xml', 'metrika');
        $this->assertLayoutFileExists('frontend', 'mygento/metrika.xml');
    }
}

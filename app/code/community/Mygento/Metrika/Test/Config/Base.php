<?php

/**
 *
 * @category   Mygento
 * @package    Mygento_Metrika
 * @copyright  Copyright © 2015 NKS LLC. (http://www.mygento.ru)
 */
class Mygento_Metrika_Test_Config_Base extends EcomDev_PHPUnit_Test_Case_Config
{

    /**
     * @test
     */
    public function testValidCodepool()
    {
        $this->assertModuleCodePool('community');
    }

    /**
     * @test
     */
    public function testBlockAlias()
    {
        $this->assertBlockAlias('metrika/tracker', 'Mygento_Metrika_Block_Tracker');
    }

    /**
     * @test
     */
    public function testHelperAlias()
    {
        $this->assertHelperAlias('metrika', 'Mygento_Metrika_Helper_Data');
    }
}

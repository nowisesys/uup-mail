<?php

namespace UUP\Mail\Compose;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-03-17 at 13:27:17.
 */
class MessageOptionsTest extends \PHPUnit_Framework_TestCase
{

        /**
         * @var MessageOptions
         */
        protected $object;
        private static $options = array(
                'contact_addr' => 'contact@example.com',
                'contact_name' => 'Contact name',
                'app_name'     => 'App name',
                'app_base'     => 'http://localhost/uup-mail'
        );

        /**
         * Sets up the fixture, for example, opens a network connection.
         * This method is called before a test is executed.
         */
        protected function setUp()
        {
                $this->object = new MessageOptions(self::$options);
        }

        /**
         * Tears down the fixture, for example, closes a network connection.
         * This method is called after a test is executed.
         */
        protected function tearDown()
        {
                
        }

        /**
         * @covers UUP\Mail\Compose\MessageOptions::__get
         */
        public function test__get()
        {
                foreach (array_keys(self::$options) as $prop) {
                        $this->assertNotNull($this->object->$prop);
                        $this->assertTrue($this->object->$prop == self::$options[$prop]);
                }
        }

        /**
         * @covers UUP\Mail\Compose\MessageOptions::merge
         */
        public function testMerge()
        {
                $options = array(
                        'contact_addr' => '1 contact@example.com',
                        'contact_name' => '1 Contact name',
                        'app_name'     => '1 App name',
                        'app_base'     => '1 http://localhost/uup-mail'
                );
                $this->object->merge(array());
                foreach (array_keys(self::$options) as $prop) {
                        $this->assertNotNull($this->object->$prop);
                        $this->assertTrue($this->object->$prop == self::$options[$prop]);
                }
                $this->object->merge($options);
                foreach (array_keys($options) as $prop) {
                        $this->assertNotNull($this->object->$prop);
                        $this->assertTrue($this->object->$prop == $options[$prop]);
                }
        }

        /**
         * @covers UUP\Mail\Compose\MessageOptions::instance
         */
        public function testInstance()
        {
                $instance = MessageOptions::instance();
                $this->assertNotNull($instance);
                $this->assertTrue($instance instanceof MessageOptions);
        }

        /**
         * @covers UUP\Mail\Compose\MessageOptions::setInstance
         */
        public function testSetInstance()
        {
                $instance = MessageOptions::instance();         // get default instance
                MessageOptions::setInstance($this->object);     // replace
                $this->assertTrue($instance !== $this->object);
                $this->assertTrue(MessageOptions::instance() === $this->object);
        }

}

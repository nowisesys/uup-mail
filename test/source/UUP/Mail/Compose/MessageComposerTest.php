<?php

namespace UUP\Mail\Compose;

/**
 * Generated by PHPUnit_SkeletonGenerator 1.2.1 on 2014-03-17 at 01:58:46.
 */
class MessageComposerTest extends \PHPUnit_Framework_TestCase
{

        /**
         * @var MessageComposer
         */
        protected $object;
        private $options = array(
                'base_url'     => 'localhost',
                'app_name'     => 'UUP Mail',
                'contact_name' => 'Anders Lövgren',
                'contact_addr' => 'anders.lovgren@bmc.uu.se'
        );
        private $title = 'Title';
        private $message = 'Message body.';

        /**
         * Sets up the fixture, for example, opens a network connection.
         * This method is called before a test is executed.
         */
        protected function setUp()
        {
                $this->object = new MessageComposer($this->title, $this->message, $this->options);
        }

        /**
         * Tears down the fixture, for example, closes a network connection.
         * This method is called after a test is executed.
         */
        protected function tearDown()
        {
                
        }

        /**
         * @covers UUP\Mail\Compose\MessageComposer::__get
         */
        public function test__get()
        {
                $this->assertNotNull($this->object->title);
                $this->assertTrue(is_string($this->object->title));
                $this->assertTrue($this->object->title == $this->title);

                $this->assertNotNull($this->object->message);
                $this->assertTrue(is_string($this->object->message));
                $this->assertTrue($this->object->message == $this->message);

                $this->assertNotNull($this->object->options);
                $this->assertTrue(is_array($this->object->options));

                $this->assertNotNull($this->object->sections);
                $this->assertTrue(is_array($this->object->sections));

                $this->assertNotNull($this->object->greeting);
                $this->assertTrue(is_string($this->object->greeting));

                $this->assertNotNull($this->object->footer);
                $this->assertTrue(is_string($this->object->footer));
        }

        /**
         * @covers UUP\Mail\Compose\MessageComposer::addSection
         */
        public function testAddSection()
        {
                $sect = 'head1';
                
                $this->assertTrue(count($this->object->sections) == 0);
                $this->assertFalse(isset($this->object->sections[$sect]));
                $this->object->addSection($sect);
                $this->assertTrue(count($this->object->sections) == 1);
                $this->assertTrue(isset($this->object->sections[$sect]));
        }

        /**
         * @covers UUP\Mail\Compose\MessageComposer::addContent
         */
        public function testAddContent()
        {
                $sect = 'head1';
                $text = 'Some text';
                
                $this->assertTrue(count($this->object->sections) == 0);
                $this->object->addSection($sect);
                $this->object->addContent($text);
                $this->assertTrue(isset($this->object->sections[$sect]));
                $this->assertTrue(is_array($this->object->sections[$sect]));
                $this->assertTrue($this->object->sections[$sect][0] == $text);
        }

        /**
         * @covers UUP\Mail\Compose\MessageComposer::setGreeting
         */
        public function testSetGreeting()
        {
                $text = 'Greeting';
                
                $this->object->setGreeting($text);
                $this->assertTrue($this->object->greeting == $text);
        }

        /**
         * @covers UUP\Mail\Compose\MessageComposer::setFooter
         */
        public function testSetFooter()
        {
                $text = 'Footer';
                
                $this->object->setFooter($text);
                $this->assertTrue($this->object->footer == $text);
        }

}

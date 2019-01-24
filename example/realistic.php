<?php

/*
 * Copyright (C) 2014 Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University).
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

require_once '../vendor/autoload.php';
require_once '../config/smtp.inc';

// 
// This is a more realistic example on how to use this library. Programming
// are done against the UUP\Mail interface using swiftmailer as the concrete
// implementaion of its interfaces.
//

/**
 * This is out message service that creates native messages from message 
 * composer objects. The formatter is fixed at startup time. We simply reuse
 * the send() method from the parent class.
 * 
 * If the same message service is used for the whole application, then it
 * makes sense to let it initialize the message options (through the setup()
 * function).
 */
class SwiftMessageService extends UUP\Mail\MessageService
{

        private $formatter;

        public function __construct($formatter, $config)
        {
                $this->formatter = $formatter;
                self::setup($config);
                parent::__construct(new UUP\Mail\Mailer\Swift\SmtpMailer($config['host'], $config['port']));
        }

        public function create($composer, $formatter = null)
        {
                return parent::create($composer, isset($formatter) ? $formatter : $this->formatter);
        }

        private static function setup($config)
        {
                $options = \UUP\Mail\Compose\MessageOptions::instance();
                $options->merge($config);
        }

}

// 
// Our collection of composer classes. Might be many more in a real application.
// 
class Message1 extends UUP\Mail\Compose\MessageComposer
{

        public function __construct()
        {
                parent::__construct('Message1', '...');
        }

}

class Message2 extends UUP\Mail\Compose\MessageComposer
{

        public function __construct()
        {
                parent::__construct('Message2', 'Main section content text.');
                parent::addSection('Header 1');
                parent::addContent('This text should be places in the sub section.');
                parent::addContent('Next paragraph...');
                parent::addSection('Header 2');
                parent::addContent('Content in second section...');
                parent::setGreeting('Hello world!');
        }

}

// 
// Create the formatter object from template files on disk.
// 
$formatter = new \UUP\Mail\Compose\MessageFormatter(
    new \UUP\Mail\Compose\MessageTemplate($config['templates']['html']), new \UUP\Mail\Compose\MessageTemplate($config['templates']['text'])
);

// 
// Create instance of out message service:
// 
$service = new SwiftMessageService($formatter, array_merge($config['smtp'], $config['mail'], $config['message']));

// 
// Create native message using our message composer:
// 
$message = $service->create(new Message1());
$message->setSubject('Mail service test (#1)');
$message->setFrom($config['mail']['from']);
$message->addTo($config['mail']['to']);
$message->attachFile(__FILE__, 'application/x-php');

// 
// Send the message using service delegate method:
// 
$service->send($message);

// 
// Test second message:
// 
$message = $service->create(new Message2());
$message->setSubject('Mail service test (#2)');
$message->setFrom($config['mail']['from']);
$message->addTo($config['mail']['to']);
$service->send($message);

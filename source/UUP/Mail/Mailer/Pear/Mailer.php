<?php

/*
 * Copyright (C) 2014 Anders Lövgren (QNET/BMC CompDept).
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

namespace UUP\Mail\Mailer\Pear;

use UUP\Mail\MessageMailer;

require_once 'Mail.php';

/**
 * Mail message delivery using PEAR Mail.
 * 
 * This class adds support for using PEAR Mail and any of its concrete implementation
 * classes for doing mail message delivery. The wanted driver name (i.e. 'smtp') is
 * passed to the constructor:
 * 
 * <code>
 * $message = new Pear\Message(new ConfirmAccountRequest(), $formatter);
 * // ... more message function calls...
 * 
 * $mailer = new Pear\Mailer('smtp', $config['smtp']);
 * $mailer->send($message);
 * </code>
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class Mailer implements MessageMailer
{

        /**
         * @var Mail 
         */
        private $mailer;
        /**
         * @var array Message parameters.
         */
        private $params;

        /**
         * Constructor.
         * @param string $driver The mail driver (i.e. smtp or sendmail).
         * @param array $params Array of driver and message options (keyed by 'driver' and 'header').
         */
        public function __construct($driver, $params = array('driver' => array(), 'header' => array()))
        {
                $this->mailer = \Mail::factory($driver, $params['driver']);
                $this->params = $params['header'];
        }

        public function create($composer, $formatter)
        {
                return new Message($composer, $formatter);
        }

        public function send($message)
        {
                $head = $this->params;
                $body = $message->get();
                $head = $message->headers($head);
                $this->mailer->send($head['To'], $head, $body);
        }

}

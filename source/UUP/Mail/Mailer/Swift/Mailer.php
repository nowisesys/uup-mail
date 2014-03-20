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

namespace UUP\Mail\Mailer\Swift;

use UUP\Mail\MessageMailer;

/**
 * Generic mailer using the Swift Mailer and Transport classes.
 * 
 * For most applications, the transport used for initialization will be a Sendmail
 * or SMTP transport, but its also possible to initialize it with more exotic
 * transports as Failover or Load Balancing transports.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class Mailer implements MessageMailer
{

        private $impl;

        /**
         * Constructor.
         * @param \Swift_Transport $transport The Swift Mailer transport to use for delivery.
         */
        public function __construct(\Swift_Transport $transport)
        {
                $this->impl = \Swift_Mailer::newInstance($transport);
        }

        public function create($composer, $formatter)
        {
                return new Message($composer, $formatter);
        }

        public function send($message)
        {
                $this->impl->send($message);
        }

}

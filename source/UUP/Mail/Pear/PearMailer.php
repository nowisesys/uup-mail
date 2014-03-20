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

namespace UUP\Mail\Pear;

use UUP\Mail\MessageMailer;

/**
 * Description of PearSmtpMailer
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 */
class PearMailer implements MessageMailer
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
                return new PearMessage($composer, $formatter);
        }

        public function send($message)
        {
                $head = $this->params;
                $body = $message->get();
                $head = $message->headers($head);
                $this->mailer->send($head['To'], $head, $body);
        }
        
}

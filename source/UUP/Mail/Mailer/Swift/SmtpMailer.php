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

/**
 * Specialization using the Swift SMTP Transport.
 *
 * @author Anders Lövgren (QNET/BMC CompDept)
 * @package UUP
 * @subpackage Mail
 */
class SmtpMailer extends Mailer
{

        /**
         * Constructor.
         * @param string $host The SMTP server host.
         * @param int $port The SMTP server port.
         */
        public function __construct($host = 'localhost', $port = 25)
        {
                parent::__construct(\Swift_SmtpTransport::newInstance($host, $port));
        }

}

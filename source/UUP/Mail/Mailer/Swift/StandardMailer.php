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

namespace UUP\Mail\Mailer\Swift;

/**
 * Specialization using the Swift Mail Transport.
 * 
 * The mail transport is done using the standard PHP mail() function.
 *
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
 * @package UUP
 * @subpackage Mail
 */
class StandardMailer extends Mailer
{

        /**
         * Constructor.
         * @param string $params
         */
        public function __construct($params = '-f%s')
        {
                parent::__construct(\Swift_MailTransport::newInstance($params));
        }

}

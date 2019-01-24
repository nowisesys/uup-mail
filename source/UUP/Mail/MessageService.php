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

namespace UUP\Mail;

/**
 * The mail message service.
 * 
 * Delegate service for the real message mailer service. The concrete implementation
 * is passed as an argument to this class constructor. The send() and create() methods
 * are merely delegating the task to its concrete mailer service object.
 * 
 * Example using the Swift Mailer for SMTP transport:
 * <code>
 * use UUP\Mail\Mailer,
 *     UUP\Mail;
 * 
 * $mailer  = new Swift\SmtpMailer($config['host'], $config['port');
 * 
 * $service = new MessageService($mailer);
 * $message = $service->create($composer, $formatter);  // Create native message from composed.
 * $message->setSubject(...);
 * $message->setFrom(...);
 *      ...
 * 
 * $service->send($message);    // Send message using service delegate ($mailer).
 * </code>
 * 
 * @author Anders Lövgren (Nowise Systems/BMC-IT, Uppsala University)
 * @package UUP
 * @subpackage Mail
 */
class MessageService implements MessageMailer
{

        /**
         * @var MessageMailer 
         */
        protected $mailer;

        /**
         * Constructor.
         * @param MessageMailer $mailer
         */
        public function __construct($mailer)
        {
                $this->mailer = $mailer;
        }

        public function send($message)
        {
                $this->mailer->send($message);
        }

        public function create($composer, $formatter)
        {
                return $this->mailer->create($composer, $formatter);
        }

}

<?php

// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Form for editing block_itutor_chat instances.
 *
 * @package   block_itutor_chat
 * @copyright 2013 Karsten Lundqvist
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

class block_itutor_chat_edit_form extends block_edit_form {
    protected function specific_definition($mform) {
        global $CFG;

        // Fields for editing HTML block title and contents.
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block'));

        $mform->addElement('text', 'config_chataddress', get_string('chataddress', 'block_itutor_chat'));
        $mform->setDefault('config_chataddress', 'itutorchat@ks3299186.kimsufi.com');
        $mform->setType('config_chataddress', PARAM_TEXT);
		
		
        $mform->addElement('text', 'config_jid', get_string('jid', 'block_itutor_chat'));
        $mform->setDefault('config_jid', 'strophe@ks3299186.kimsufi.com');
        $mform->setType('config_jid', PARAM_TEXT);
		
		
        $mform->addElement('text', 'config_password', get_string('password', 'block_itutor_chat'));
        $mform->setDefault('config_password', '');
        $mform->setType('config_password', PARAM_TEXT);

    }

}

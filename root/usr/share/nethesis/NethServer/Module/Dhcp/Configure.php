<?php
namespace NethServer\Module\Dhcp;

/*
 * Copyright (C) 2011 Nethesis S.r.l.
 * 
 * This script is part of NethServer.
 * 
 * NethServer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * NethServer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with NethServer.  If not, see <http://www.gnu.org/licenses/>.
 */

use \Nethgui\System\PlatformInterface as Validate;

/**
 * Implement gui module for /etc/hosts configuration
 */
class Configure extends \Nethgui\Controller\TableController
{

    public function initialize()
    {
        $columns = array(
            'Key',
            'DhcpRangeStart',
            'DhcpRangeEnd',
        );


        $parameterSchema = array(
            array('interface', Validate::ANYTHING, \Nethgui\Controller\Table\Modify::KEY),
            array('DhcpRangeStart', Validate::IPv4, \Nethgui\Controller\Table\Modify::FIELD),
            array('DhcpRangeEnd', Validate::IPv4, \Nethgui\Controller\Table\Modify::FIELD),
        );

        $this
            ->setTableAdapter($this->getPlatform()->getTableAdapter('dhcp', 'range'))
            ->setColumns($columns)
            ->addTableAction(new \Nethgui\Controller\Table\Help('Help'))
        ;

        parent::initialize();
    }

    public function prepareViewForColumnKey(\Nethgui\Controller\Table\Read $action, \Nethgui\View\ViewInterface $view, $key, $values, &$rowMetadata)
    {
        if (!isset($values['status']) || ($values['status'] == 'disabled')) {
            $rowMetadata['rowCssClass'] = trim($rowMetadata['rowCssClass'] . ' user-locked');
        }

        return strval($key);
    }

}

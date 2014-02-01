<?php

/*
 *
 *
 * Copyright (c) 2010 158, Ltd.
 * All Rights Reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification are not permitted.
 *
 * Neither the name of 158, Ltd. or the names of contributors
 * may be used to endorse or promote products derived from this software
 * without specific prior written permission.
 *
 * This software is provided "AS IS," without a warranty of any kind. ALL
 * EXPRESS OR IMPLIED CONDITIONS, REPRESENTATIONS AND WARRANTIES, INCLUDING
 * ANY IMPLIED WARRANTY OF MERCHANTABILITY, FITNESS FOR A PARTICULAR
 * PURPOSE OR NON-INFRINGEMENT, ARE HEREBY EXCLUDED. 158 AND ITS LICENSORS
 * SHALL NOT BE LIABLE FOR ANY DAMAGES SUFFERED BY LICENSEE AS A RESULT OF
 * USING, MODIFYING OR DISTRIBUTING THE SOFTWARE OR ITS DERIVATIVES. IN NO
 * EVENT WILL 158 OR ITS LICENSORS BE LIABLE FOR ANY LOST REVENUE, PROFIT
 * OR DATA, OR FOR DIRECT, INDIRECT, SPECIAL, CONSEQUENTIAL, INCIDENTAL OR
 * PUNITIVE DAMAGES, HOWEVER CAUSED AND REGARDLESS OF THE THEORY OF
 * LIABILITY, ARISING OUT OF THE USE OF OR INABILITY TO USE SOFTWARE, EVEN
 * IF 158 HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES.
 *
 * Any violation of the copyright rules above will be punished by the lay.
 */

/**
 * Manages am action filter item
 */
class ActionFilterItem {

    private $action;
    private $controllerObject;
    private $except = array();
    private $only = array();

    public function __construct($controllerObject, $action) {
        $this->action = $action;
        $this->controllerObject = $controllerObject;
    }

    public function only(array $actions) {
        $this->only = array_merge($this->only, $actions);
    }

    public function except(array $actions) {
        $this->except = array_merge($this->except, $actions);
        ;
    }

    public function execute() {
        if (isset($_REQUEST['action'])) {
            $action = $_REQUEST['action'];
            if (count($this->only) > 0) {
                if (in_array($action, $this->only)) {
                    $this->controllerObject->{$this->action}();
                }
            } elseif (count($this->except > 0)) {
                if (!in_array($action, $this->except)) {
                    $this->controllerObject->{$this->action}();
                }
            } else {
                $this->controllerObject->{$this->action}();
            }
        } else {
            $this->controllerObject->{$this->action}();
        }
    }

}

?>

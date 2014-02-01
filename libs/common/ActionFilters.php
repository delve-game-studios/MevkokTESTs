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
 * The ActionFilters class manages the Controller before and aftre filters
 */
class ActionFilters {
    
    /**
     * An array contaning the before filters
     * @var array 
     */
    private $before = array();
    
    /**
     * An array containing the after filters
     * @var type 
     */
    private $after = array();
    
    /**
     * Contains the controller object
     * @var Controller 
     */
    private $controllerObject;
    
    /**
     * Creates an instance of ActionFilters
     * @param Controller $controllerObject the current controllers object
     */
    public function __construct($controllerObject) {
        $this->controllerObject = $controllerObject;
    }
    
    /**
     * Excutes all the before filters
     */
    public function before() {
        foreach($this->before as $filter) {
            $filter->execute();
        }
    }
    
    /**
     * Executes all the after filters 
     */
    public function after() {
        foreach($this->after as $filter) {
            $filter->execute();
        }
    }
    
    /**
     * Add a filter to the object
     * @param string $filter The filter type e.g. before or after
     * @param string $method the controller's action
     */
    public function add($filter, $action) {
        if(isset($this->{$filter})) {
            if(!isset($this->{$filter}[$action])) {
                $filterItem = new ActionFilterItem($this->controllerObject, $action);
                $this->{$filter}[$action] = $filterItem;
            }
            return $this->{$filter}[$action];
        }
    }
}

?>

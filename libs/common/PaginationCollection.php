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
 * Description of PaginationCollection
 * 
 * Pagination collection to use with database objects separated in pages.
 */
class PaginationCollection extends ArrayObject {
    
    /**
     * Contains the generated page links.
     * @var string 
     */
    private $pagination;
    
    /**
     * Number of objects per page
     * @var integer 
     */
    private $pageSize;
    
    /**
     * Number of pages
     * @var integer 
     */
    private $pageCount;
    
    /**
     * The current page index.
     * @var integer 
     */
    private $currentPage;
    
    /**
     * Creates a pagination collection
     * @param array $array The array of database objects
     * @param string $pagination Contains the generated page links.
     * @param integer $pageSize Number of objects per page
     * @param integer $pageCount Number of pages
     */
    public function __construct($array, $pagination, $pageSize, $pageCount, $currentPage) {
        parent::__construct($array);
        $this->pagination = $pagination;
        $this->pageCount = $pageCount;
        $this->pageSize = $pageSize;
        $this->currentPage = $currentPage;
    }
    
    /**
     * Returns the generated page links.
     * @return string The generated links 
     */
    public function paginator() {
        return $this->pagination;
    }
    
    /**
     * @return integer number of objects per page 
     */
    public function getPageSize() {
        return $this->pageSize;
    }

    /**
     * @return integer number of pages 
     */
    public function getPageCount() {
        return $this->pageCount;
    }
    
    /**
     * Get the current page index.
     * @return integer 
     */
    public function getCurrentPage() {
        return $this->currentPage;
    }
}

?>

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
 * Description of Pagination
 *
 * Used for separating the a Database object in pages using the database LIMIT clause<br />
 * The Pagination class uses the PaginationCollection class to contain the collection of Databese objects. <br />
 * Global Configuration: <br />
 * Default Configuration:<br />
 * <pre>
 * Pagination::$config = array(
 *       'pageSize'              => 15,
 *       'param'                 => 'page',
 *       'showFirstAndLast'      => true,
 *       'showNextAndPrevious'   => true,
 *       'firstLabel'            => '&#171;',
 *       'lastLabel'             => '&#187;',
 *       'prevLabel'             => '&lsaquo;',
 *       'nextLabel'             => '&rsaquo;',
 *       'pagesShown'            => 7,
 *       'endPagesShown'         => 2
 *   );
 * </pre>
 * <br />
 * To override the golobal conections you will have to add an entry to the enviroment configurations
 */
class Pagination {
    /**
     * Global configuration array <br />
     * <pre>
     * Pagination::$config = array(
     *       'pageSize'              => 15,
     *       'param'                 => 'page',
     *       'showFirstAndLast'      => true,
     *       'showNextAndPrevious'   => true,
     *       'firstLabel'            => '&#171;',
     *       'lastLabel'             => '&#187;',
     *       'prevLabel'             => '&lsaquo;',
     *       'nextLabel'             => '&rsaquo;',
     *       'pagesShown'            => 7,
     *       'endPagesShown'         => 2
     *   );
     * </pre>
     * @var array
     */
    public static $config = array(
        'pageSize'              => 15,
        'param'                 => 'page',
        'showFirstAndLast'      => true,
        'showNextAndPrevious'   => true,
        'firstLabel'            => '&#171;',
        'lastLabel'             => '&#187;',
        'prevLabel'             => '&lsaquo;',
        'nextLabel'             => '&rsaquo;',
        'pagesShown'            => 7,
        'endPagesShown'         => 2,
        'source'                => 'get'
    );

    protected $pageSize;
    protected $pageCount;
    protected $currentPage;
    protected $model;

    // Navigation Configurations
    protected $param;
    protected $showFirstAndLast;
    protected $showNextAndPrevious;
    protected $firstLabel;
    protected $lastLabel;
    protected $prevLabel;
    protected $nextLabel;
    protected $pagesShown;
    protected $endPagesShown;

    protected $queryString;
    protected $linkTitle;
    protected $source;

    /**
     * Creates a pagination instance.
     * @param Database $model a Databse model with loaded query but not yet executed: <br />
     * <pre>
     *      $model = Database::db()->select()->where('id=?');
     *      $paginatedModel = new Pagination($model);
     *      $paginatedModel->paginate(array($id));
     * </pre>
     */
    public function __construct($model) {
        $this->model = $model;

        $this->setConfiguration(self::$config);
    }

    /**
     * Overrides the golbal configuration for the current instance.
     * @param array $config The configuration variables that you want to override.
     */
    private function setConfiguration($config) {
        foreach ($config as $attr => $val) {
            $this->{$attr} = $val;
        }
    }

    /**
     * Set the size of the page
     * @param integer $pageSize
     */
    public function setPageSize($pageSize) {
        $this->pageSize = $pageSize;
    }

    /**
     * Set the http request parameter that contains the current page index.
     * @param string $param
     */
    public function setParam($param) {
        $this->param = $param;
    }

    /**
     * If set to true it will show the first and last buttons in the pagination links.
     * @param bool $showFirstAndLast
     */
    public function setShowFirstAndLast($showFirstAndLast) {
        $this->showFirstAndLast = $showFirstAndLast;
    }

    /**
     * If set to true it will show the next and previous links.
     * @param type $showNextAndPrevious
     */
    public function setShowNextAndPrevious($showNextAndPrevious) {
        $this->showNextAndPrevious = $showNextAndPrevious;
    }

    /**
     * The nuber of page indexes shown.
     * @param integer $pagesShown
     */
    public function setPagesShown($pagesShown) {
        $this->pagesShown = $pagesShown;
    }

    /**
     * Number of ending page indexes shown
     * @param type $endPagesShown
     */
    public function setEndPagesShown($endPagesShown) {
        $this->endPagesShown = $endPagesShown;
    }

    public function setFirstLabel($firstLabel) {
        $this->firstLabel = $firstLabel;
    }

    public function setLastLabel($lastLabel) {
        $this->lastLabel = $lastLabel;
    }

    public function setPrevLabel($prevLabel) {
        $this->prevLabel = $prevLabel;
    }

    public function setNextLabel($nextLabel) {
        $this->nextLabel = $nextLabel;
    }

    /**
     * Get the number of pages.
     * @return type
     */
    public function getPageCount() {
        return $this->pageCount;
    }

    /**
     * Get the paginated model's object.
     * @return type
     */
    public function getModel() {
        return $this->model;
    }

    /**
     * Executes the mysql query and separates the model's objects into pages.
     * @param (null/array) $bindParams parameters to bind with the prepared query.
     * @param array $config The configuration variables that you want to override.
     * @return PaginationCollection contains data for the paginated objects
     */
    public function paginate($bindParams = null, array $config = array()) {
        $this->setConfiguration($config);

        $this->setCurrentPage();
        $links = $this->separeate($bindParams);

        $objects = $this->model->limit($this->buildLimit())->prepare($bindParams);

        return new PaginationCollection($objects, $links,
                        $this->pageSize, $this->pageCount, $this->currentPage);
    }

    /**
     * Generates the page indexes and builds the link tags.
     * @return string The generated links
     */
    protected function separeate($bindParams = null) {
        $links = '';
        // css class variable definitions
        $cssNext = 'page-navigation page-next';
        $cssPrevious = 'page-navigation page-previous';
        $cssFirst = 'page-navigation page-first';
        $cssLast = 'page-navigation page-last';
        $cssPage = 'page-number';
        $cssCurrentPage = 'page-current';

        $model = clone $this->model;
        $rows = $model->count($bindParams);

        $this->pageCount = ceil($rows / $this->pageSize);

        unset($rows, $model);

        $this->buildQueryString();


        // Page links by index
        if ($this->pageCount > 0) {
            // first and previous links;
            if($this->currentPage > 1) {
                if($this->showFirstAndLast) {
                    $links .= $this->buildLink(1, $this->firstLabel, $cssFirst);
                }

                if($this->showNextAndPrevious) {
                    $links .= $this->buildLink($this->currentPage - 1, $this->prevLabel, $cssPrevious);
                }
            }

            if(is_null($this->pagesShown)) {
                for ($i = 1; $i <= $this->pageCount; $i++) {
                    if($this->currentPage == $i) {
                        $links .= '<span class="' . $cssCurrentPage . '">' . $i . '</span>' . PHP_EOL;
                    } else {
                        $links .= $this->buildLink($i, $i, $cssPage);
                    }
                }
            } else {
                $maxPages = floor($this->pagesShown / 2);

                $startPage = $this->currentPage - $maxPages;
                $endPage = $this->currentPage + $maxPages;

                if($startPage < 1) {
                    $endPage = $endPage - $startPage + 1;
                    $startPage = 1;
                    // normalize pagination
                    if($endPage > $this->pageCount) {
                        $endPage = $this->pageCount;
                    }
                }elseif($endPage > $this->pageCount) {
                    $startPage = $startPage - ($endPage - $this->pageCount);
                    $endPage = $this->pageCount;
                    //normalize pagination
                    if($startPage < 1) {
                        $startPage = 1;
                    }
                }

                if(!is_null($this->endPagesShown) && $this->endPagesShown != 0) {
                    if($startPage > 1) {
                        $fistPages = 1 + ($this->endPagesShown - 1);

                        if($startPage <= $fistPages) {
                            $fistPages = $startPage - 1;
                        }

                        for($i = 1; $i <= $fistPages; $i++) {
                            $links .= $this->buildLink($i, $i, $cssPage);
                        }

                        $links .= '<span>...</span>' . PHP_EOL;
                    }
                }


                for ($i = $startPage ; $i <= $endPage; $i++) {
                    if($this->currentPage == $i) {
                        $links .= '<span class="' . $cssCurrentPage . '">' . $i . '</span>' . PHP_EOL;
                    } else {
                        $links .= $this->buildLink($i, $i, $cssPage);
                    }
                }

                if(!is_null($this->endPagesShown) && $this->endPagesShown != 0) {
                    if($endPage < $this->pageCount) {
                        $links .= '<span>...</span>' . PHP_EOL;

                        $lastPages = $this->pageCount - ($this->endPagesShown - 1);

                        if($endPage >= $lastPages) {
                            $lastPages = $endPage + 1;
                        }

                        for($i = $lastPages; $i <= $this->pageCount; $i++) {
                            $links .= $this->buildLink($i, $i, $cssPage);
                        }
                    }
                }
            }

            // Last and next
            if($this->currentPage < $this->pageCount) {
                if($this->showNextAndPrevious) {
                    $links .= $this->buildLink($this->currentPage + 1, $this->nextLabel, $cssNext);
                }

                if($this->showFirstAndLast) {
                    $links .= $this->buildLink($this->pageCount, $this->lastLabel, $cssLast);
                }
            }
        }

        return $links;
    }

    /**
     * Builds a html link tag.
     * @param integer $pageIndex the index of the page
     * @param string $label the label of the link
     * @param string $cssClass a css class
     * @return string the link tag
     */
    protected function buildLink($pageIndex, $label, $cssClass = null) {
        return '<a class="' . $cssClass . '" href="' . $this->buildUrl($pageIndex) . '" title="' . $this->linkTitle . $label . '">' . $label . '</a>' . PHP_EOL;
    }

    /**
     * Rebuilds the query string.
     */
    protected function buildQueryString() {
        $queryString = '';
        $params = $_GET;
        if(isset($params[$this->param])) {
            unset($params[$this->param]);
        }

        foreach ($params as $key => $value) {
            $queryString .= $key . '=' . $value . '&';
        }

        $queryString = rtrim($queryString, '&');

        $this->queryString = $queryString;
    }

    /**
     * Builds the query string and adds the page parameter to it
     * @param integer $pageIndex the index of the page
     * @return string the new query string
     */
    protected function buildUrl($pageIndex) {
        switch ($this->source) {
            case 'get':
                return $this->buildUrlFromGet($pageIndex);
            case 'request':
                return $this->buildUrlFromRequest($pageIndex);
            default:
                return $this->buildUrlFromGet($pageIndex);
        }
    }

    /**
     * Builds a url with using $_GET as a source
     * @param integer $pageIndex the index of the page
     * @return string the new query string
     */
    protected function buildUrlFromGet($pageIndex) {
        if(strlen($this->queryString) > 0) {
            return $_SERVER['REQUEST_URI'].'?' . $this->queryString . '&' . $this->param . '=' . $pageIndex;
        } else {
            return $_SERVER['REQUEST_URI'].'?' . $this->param . '=' . $pageIndex;
        }
    }

    /**
     * Builds a url with using $_REQUEST as a source and $_SERVER['REQUEST_URI'] as destination
     * ex. /route/:pageIndex
     * @param integer $pageIndex the index of the page
     * @return string the new query string
     */
    protected function buildUrlFromRequest($pageIndex) {
        $params = array();
        foreach($_REQUEST as $key => $value) {
            if(!in_array($key, array('controller', 'action')) &&
                    !isset($_GET[$key]) &&
                    !isset($_POST[$key])) {
                $params[$key] = $value;
            }
        }
        
        $params[$this->param] = $pageIndex;
        
        return routeTo(Route::buildUrl($_REQUEST['controller'], $_REQUEST['action'], $params));
    }

    /**
     * Loads the current page index.
     */
    protected function setCurrentPage() {
        if (isset($_REQUEST[$this->param])) {
            $_REQUEST[$this->param] = (int) $_REQUEST[$this->param];
        } else {
            $_REQUEST[$this->param] = 1;
        }

        $_REQUEST[$this->param] = (int) $_REQUEST[$this->param];
        if ($_REQUEST[$this->param]) {
            $this->currentPage = $_REQUEST[$this->param];
        } else {
            $this->currentPage = 1;
        }
    }

    /**
     * Generates the limit for use with the mysql query.
     * @return string mysql limit
     */
    protected function buildLimit() {
        $from = (($this->currentPage * $this->pageSize) - $this->pageSize);
        return $from . ',' . $this->pageSize;
    }

}

?>

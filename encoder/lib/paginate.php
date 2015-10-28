<?php

class Paginate extends Object {

    /**
     * @FindParams
     */
    static $model;
    static $limit = 20;
    static $order = '';
    static $fields = '*';
    static $where = '';

    /**
     * @PaginateParams
     */
    static $page = 1;
    private static $offset;
    private static $page_forward;
    private static $page_back;
    private static $total_pages;
    private static $total_records;
    private static $record_start;
    private static $record_end;

    /**
     * @UrlParams
     */
    private static $url_back;
    private static $url_forward;

    static function init() {
        self::$page = data('page') ? : self::$page;
        self::$limit = data('limit') ? : self::$limit;
        self::$order = data('order') ? : self::$order;
        self::$where = data('where') ? : self::$where;
    }

    static function find($options = array()) {
        # <implements>
        #   check if page exists
        # <implements>

        $m = self::$model;
        return $m::find(self::set_options($options));
    }

    /**
     * Efetua a contagem de registros presentes na paginação atual.
     * 
     * @return int
     */
    static function total_records() {
        if (!empty(self::$total_records))
            return self::$total_records;

        $m = self::$model;
        return $m::count(self::where());
    }

    /**
     * Get position number of first record on find.
     * 
     * @return int
     */
    static function record_start() {
        if (!empty(self::$record_start))
            return self::$record_start;

        return $record_start = 1 + self::limit() * (self::page() - 1);
    }

    /**
     * Get position number of last record on find.
     * 
     * @return int
     */
    static function record_forward() {
        if (!empty(self::$record_forward))
            return self::$record_forward;

        return $record_start = self::limit() * self::page();
    }

    /**
     * Gets current page.
     * 
     * @return int
     */
    static function page_current() {
        return self::$page;
    }

    /**
     * Gets current page.
     * 
     * @return int
     */
    static function page_back() {
        return self::$page - 1 <= 0 ? 0 : self::$page - 1;
    }

    /**
     * Gets current page.
     * 
     * @return int
     */
    static function page_forward() {
        return self::$page + 1 > self::total_pages() ? null : self::$page + 1;
    }

    /**
     * Count total pages on last find
     * 
     * @return int
     */
    static function total_pages() {
        if (!empty(self::$total_pages))
            return self::$total_pages;

        return self::$total_pages = ceil((self::total_records() / self::limit()));
    }

    /**
     * Check if any page exists
     * 
     * @param int $page
     * @return boolean
     */
    static function page_exists($page) {
        return $page > 0 && $page <= self::total_pages();
    }

    /**
     * Check if current page exists
     * 
     * @return boolean
     */
    static function page_current_exists() {
        return self::page_exists(self::page());
    }

    /**
     * Get url to access Previus page of find
     * 
     * @return string or null
     */
    static function url_back() {
        if (!empty(self::$url_back))
            return self::$url_back;

        if (($back = self::page() - 1) < 1)
            return null;

        $query = Request::query_get('page', $back);
        $url = explode('?', Url::$current);
        return self::$url_back = $url[0] . '?' . $query;
    }

    /**
     * Get url to access Next page of find
     * 
     * @return string or null
     */
    static function url_forward() {
        if (!empty(self::$url_forward))
            return self::$url_forward;

        $next = (self::page() + 1);
        if ($next > self::total_pages())
            return null;

        $query = Request::query_get('page', $next);
        $url = explode('?', Url::$current);
        return self::$url_forward = $url[0] . '?' . $query;
    }

    static function href_url_back() {
        $url = self::url_back();
        return $url ? "href='$url'" : '';
    }

    static function href_url_forward() {
        $url = self::url_forward();
        return $url ? "href='$url'" : '';
    }

    # ---------- #
    #  @private  #
    # ---------- #

    /**
     * Set page to find records.
     * 
     * @param int $page
     * @return int
     */
    private static function page($page = null) {
        return self::$page = $page ? : self::$page;
    }

    /**
     * Get SQL LIMIT clause to find.
     * 
     * @param int $limit
     * @return string
     */
    private static function limit($limit = null) {
        return self::$limit = $limit ? : self::$limit;
    }

    /**
     * Get SQL ORDER clause to find.
     * 
     * @param string $order
     * @return string
     */
    private static function order($order = null) {
        return self::$order = $order ? : self::$order;
    }

    /**
     * Get SQL WHERE clause to find.
     * 
     * @param string, array $where
     * @return string
     */
    private static function where($where = null) {
        return self::$where = $where ? : self::$where;
    }

    /**
     * Get SQL OFFSET clause to find.
     * 
     * @return int
     */
    private static function offset() {
        return self::$offset = self::$page * self::limit() - self::limit();
    }

    /**
     * Get generator SQL class name.
     * 
     * @return string
     */
    private static function sql_class_name() {
        $m = self::$model;
        return strtolower($m::datasource()) . '\Sql';
    }

    /**
     * @param array $options
     * $return array $options
     */
    private static function set_options(array $options) {
        self::page(@$options['page']);
        $options['limit'] = self::limit(@$options['limit']);
        $options['order'] = self::order(@$options['order']);
        $options['where'] = self::where(@$options['where']);
        $options['offset'] = self::offset();

        return $options;
    }

}

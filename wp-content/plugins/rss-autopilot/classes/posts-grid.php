<?php

namespace RSSAutopilot;

/**
 * Class PostsGrid
 * @package RSSAutopilot
 */
class PostsGrid {
    private $foundItems;
    private $postType;
    private $totalPages;

    /**
     * Init PostsGrid with postType and optional filters
     * @param $postType
     * @param array $filters
     */
    public function __construct($postType, $filters=array())
    {
        $this->postType = $postType;
        $this->find($filters);
    }

    /**
     * Get items list for grid
     * @param int $itemPerPage
     * @return array
     */
    public function getList($itemPerPage = 10)
    {
        $args = array(
            'posts_per_page' => $itemPerPage,
            'orderby' => 'date',
            'order' => 'DESC',
            'offset' => ( $this->getPageNum() - 1 ) * $itemPerPage
        );

        if ( ! empty( $_REQUEST['s'] ) )
            $args['s'] = $_REQUEST['s'];

        if ( ! empty( $_REQUEST['orderby'] ) ) {
            if ( 'title' == $_REQUEST['orderby'] )
                $args['orderby'] = 'title';
            elseif ( 'author' == $_REQUEST['orderby'] )
                $args['orderby'] = 'author';
            elseif ( 'date' == $_REQUEST['orderby'] )
                $args['orderby'] = 'date';
        }

        if ( ! empty( $_REQUEST['order'] ) ) {
            if ( 'asc' == strtolower( $_REQUEST['order'] ) )
                $args['order'] = 'ASC';
            elseif ( 'desc' == strtolower( $_REQUEST['order'] ) )
                $args['order'] = 'DESC';
        }

        $this->items = $this->find( $args );

        $totalItems = $this->count();
        $totalPages = ceil( $totalItems / $itemPerPage );

        $this->totalPages = $totalPages;

        return array(
            'list' => $this->items,
            'pagination' => array(
                'totalItems' => $totalItems,
                'totalPages' => $totalPages,
                'perPage' => $itemPerPage,
                'currentPage' => $this->getPageNum()
            )
        );
    }

    /**
     * Get current page number
     * @return mixed
     */
    public function getPageNum() {
        $pagenum = isset( $_REQUEST['paged'] ) ? absint( $_REQUEST['paged'] ) : 0;
        return max( 1, $pagenum );
    }

    /**
     * Filter grid
     * @param array $args
     * @return array
     */
    public function find( $args = array() ) {
        $defaults = array(
            'post_status' => 'any',
            'posts_per_page' => -1,
            'offset' => 0,
            'orderby' => 'ID',
            'order' => 'ASC' );

        $args = wp_parse_args( $args, $defaults );

        $args['post_type'] = $this->postType;

        $q = new \WP_Query();
        $posts = $q->query( $args );

        $this->foundItems = $q->found_posts;

        return $posts;
    }

    /**
     * Get number of found items
     * @return mixed
     */
    public function count() {
        return $this->foundItems;
    }

    /**
     * Format date
     * @param $date
     * @return string
     */
    public function formatDateHelper( $date ) {
        $t_time = mysql2date( __( 'Y/m/d g:i:s A', 'rss-autopilot' ), $date, true );
        $m_time = $date;
        $time = mysql2date( 'G', $date ) - get_option( 'gmt_offset' ) * 3600;

        $time_diff = time() - $time;

        if ( $time_diff > 0 && $time_diff < 24*60*60 )
            $h_time = sprintf( __( '%s ago', 'rss-autopilot' ), human_time_diff( $time ) );
        else
            $h_time = mysql2date( __( 'Y/m/d', 'rss-autopilot' ), $m_time );

        return '<abbr title="' . $t_time . '">' . $h_time . '</abbr>';
    }

    /**
     * Get url for sorting
     * @param $column
     * @param $bootstrap
     * @return mixed
     */
    public function orderByHelper( $column, $bootstrap ) {
        $orderBy = $column;
        $order = 'ASC';

        if (!empty( $_REQUEST['orderby'])) {
            // If grid is sorted by this column
            if ( $column == $_REQUEST['orderby'] ) {
                if (!empty( $_REQUEST['order'] ) ) {
                    if ('asc' == strtolower($_REQUEST['order'])) {
                        $order = 'DESC';
                    } else {
                        $order = 'ASC';
                    }
                }
            }
        }

        return $bootstrap->menuUrl('rssap-'.$bootstrap->currentPage, $bootstrap->currentAction, array('orderby'=>$orderBy, 'order'=>$order));
    }

    /**
     * Get current sort state
     * @param $column
     * @return string
     */
    public function orderByStateHelper($column) {
        $str = 'sortable asc';
        if (!empty( $_REQUEST['orderby']) && $column == $_REQUEST['orderby']) {
            if ('asc' == strtolower($_REQUEST['order'])) {
                $str = 'sorted desc';
            } else {
                $str = 'sorted asc';
            }
        }

        return $str;
    }
}

?>
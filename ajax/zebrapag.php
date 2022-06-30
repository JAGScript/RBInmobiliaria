<?php
class Zebra_Pagination
{
    function Zebra_Pagination()
    {
        $this->page = 1;
        $this->selectable_pages(11);
        $this->records_per_page(10);
        $this->records(0);
        $this->padding();
        $this->variable_name('page');
        $this->method('get');
        $this->trailing_slash(true);
        $this->base_url();

    }
    
    function base_url($base_url = '')
    {
        $this->_base_url = ($base_url == '' ? $_SERVER['REQUEST_URI'] : $base_url);
        $this->_base_url = (strpos($this->_base_url, '?') !== false ? preg_replace('/^(.*?)\?.*$/', '$1', $this->_base_url) : $this->_base_url);

    }

    function get_page()
    {
        if (!isset($this->page_set)) {
            if (
                $this->_method == 'url' &&
                preg_match('/\b' . preg_quote($this->_variable_name) . '([0-9]+)\b/i', $_SERVER['REQUEST_URI'], $matches) > 0

            ) {
                $this->set_page((int)$matches[1]);
            } elseif (isset($_GET[$this->_variable_name])) {
                $this->set_page((int)$_GET[$this->_variable_name]);

            }

        }
        $this->_total_pages = ceil($this->_records / $this->_records_per_page);
        if ($this->_total_pages > 0) {
            if ($this->page > $this->_total_pages) $this->page = $this->_total_pages;
            elseif ($this->page < 1) $this->page = 1;

        }
        return $this->page;

    }

    function method($method)
    {
        $this->_method = 'get';
        $method = strtolower($method);
        if ($method == 'get' || $method == 'url') $this->_method = $method;

    }

    function padding($enabled = true)
    {
        $this->_padding = $enabled;

    }

    function records($records)
    {
        $this->_records = (int)$records;

    }
	
    function records_per_page($records_per_page)
    {
        $this->_records_per_page = (int)$records_per_page;

    }

    function render($return_output = false)
    {
        $this->get_page();
        if ($this->_total_pages <= 1) return '';
        $output = '<div><ul class="pagination">';
        if ($this->_total_pages > $this->_selectable_pages) {

            $output .= '<li ' .
                ' class="navigation prev' . ($this->page == 1 ? ' disabled' : '') . '"' .

                '><a href="' .
                ($this->page == 1 ? '#' : $this->_build_uri($this->page - 1)) . '"' .

                '>&larr; Anterior</a></li>';

        }
        if ($this->_total_pages <= $this->_selectable_pages) {
            for ($i = 1; $i <= $this->_total_pages; $i++) {
                $output .= '<li ' .
                    ($this->page == $i ? 'class="active"' : '') . '>' .

                    '<a href="' . $this->_build_uri($i) . '">' .
                    ($this->_padding ? str_pad($i, strlen($this->_total_pages), '0', STR_PAD_LEFT) : $i) .

                    '</a></li>';

            }

        } else {
            $output .= '<li ' .
                ($this->page == 1 ? 'class="active"' : '') . '>' .

                '<a href="' . $this->_build_uri(1) . '">' .
                ($this->_padding ? str_pad('1', strlen($this->_total_pages), '0', STR_PAD_LEFT) : '1') .

                '</a></li>';
            $adjacent = floor(($this->_selectable_pages - 3) / 2);
            $adjacent = ($adjacent == 0 ? 1 : $adjacent);
            $scroll_from = $this->_selectable_pages - $adjacent;
            $starting_page = 2;
            if ($this->page >= $scroll_from) {
                $starting_page = $this->page - $adjacent;

                if ($this->_total_pages - $starting_page < ($this->_selectable_pages - 2)) {
                    $starting_page -= ($this->_selectable_pages - 2) - ($this->_total_pages - $starting_page);

                }
                $output .= '<li class="disabled"><a href="#">&hellip;</a></li>';

            }
            $ending_page = $starting_page + $this->_selectable_pages - 3;

            if ($ending_page > $this->_total_pages - 1) $ending_page = $this->_total_pages - 1;

            for ($i = $starting_page; $i <= $ending_page; $i++) {

                $output .= '<li ' .

                    ($this->page == $i ? 'class="active"' : '') . '>' .
                    
                    '<a href="' . $this->_build_uri($i) . '">' .
                    ($this->_padding ? str_pad($i, strlen($this->_total_pages), '0', STR_PAD_LEFT) : $i) .

                    '</a></li>';

            }

            if ($this->_total_pages - $ending_page > 1) $output .= '<li class="disabled"><a href="#">&hellip;</a></li>';

            $output .= '<li ' .

                ($this->page == $i ? 'class="active"' : '') . '>' .
                
                '<a href="' . $this->_build_uri($this->_total_pages) . '">' .

                $this->_total_pages .

                '</a></li>';

            if ($this->_total_pages > $this->_selectable_pages) {

                $output .= '<li ' .

                    ' class="navigation next' . ($this->page == $this->_total_pages ? ' disabled' : '') . '"' .
                    
                    '><a href="' .

                    ($this->page == $this->_total_pages ? '#' : $this->_build_uri($this->page + 1)) . '"' .

                    '>Siguiente &rarr;</a></li>';

            }

        }

        $output .= '</ul></div>';

        if ($return_output) return $output;

        echo $output;

    }

    function selectable_pages($selectable_pages)
    {
        $this->_selectable_pages = (int)$selectable_pages;

    }

    function set_page($page)
    {
        $this->page = (int)$page;

        if ($this->page < 1) $this->page = 1;

        $this->page_set = true;

    }

    function trailing_slash($enabled)
    {

        $this->_trailing_slash = $enabled;

    }

    function variable_name($variable_name)
    {

        $this->_variable_name = strtolower($variable_name);

    }

    function _build_uri($page)
    {

        if ($this->_method == 'url') {

            if (preg_match('/\b' . $this->_variable_name . '([0-9]+)\b/i', $this->_base_url, $matches) > 0) {

                $url = str_replace('//', '/', preg_replace(

                    '/\b' . $this->_variable_name . '([0-9]+)\b/i',

                    ($page == 1 ? '' : $this->_variable_name . $page),

                    $this->_base_url

                ));

            } else $url = rtrim($this->_base_url, '/') . '/' . ($page != 1 ? $this->_variable_name . $page : '');

            $url = rtrim($url, '/') . ($this->_trailing_slash ? '/' : '');

            return ($_SERVER['QUERY_STRING'] != '' ? $url . '?' . $_SERVER['QUERY_STRING'] : $url);

        } else {

            parse_str($_SERVER['QUERY_STRING'], $query);

            if ($page != 1) 

                $query[$this->_variable_name] = $page;

            else unset($query[$this->_variable_name]);

            return htmlspecialchars($this->_base_url . (!empty($query) ? '?' . http_build_query($query) : ''));

        }

    }

}

?>

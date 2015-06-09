<?php

if (!function_exists('theme')) {
    /**
     * Return a specified view from current theme.
     *
     * @param string|null $view
     * @param array  $data
     * @param array  $mergeData
     *
     * @return \Illuminate\View\View
     */
    function theme($view = null, array $data = array(), array $mergeData = array())
    {
        $theme = app('themes');

        if (is_null($view)) {
            return $theme;
        }

        return $theme->view($view, $data, $mergeData);
    }
}

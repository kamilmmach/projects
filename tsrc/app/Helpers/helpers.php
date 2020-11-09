<?php

function flash($message, $level = 'info')
{
    session()->flash('flash_message', $message);
    session()->flash('flash_message_level', $level);
}

function sortable_get_url($column)
{
    $params = array_merge(Request::all(), array('s' => $column, 'o' => (Request::get('o') == 'asc' ? 'desc' : 'asc')));

//	dd(Route::getCurrentRoute()->getActionName());

    return route(Route::current()->getName(), $params);
}

function sortable_get_indicator($column)
{
    $indicator = null;
    if (Request::has('s') && Request::has('o')) {
        if (Request::get('s') == $column) {
            $indicator = (Request::get('o') == 'asc' ? '<i class="fa fa-sort-asc" aria-hidden="true"></i>' : '<i class="fa fa-sort-desc" aria-hidden="true"></i>');
        }
    }

    return $indicator;
}

function get_sortable_link($column, $title = null)
{
    $html = sortable_get_indicator($column) . ' <a href="' . sortable_get_url($column) . '">' . ($title != null ? $title : $column) . '</a>';

    return $html;
}

function isActiveRoute($route)
{
    if(Route::currentRouteName() == $route)
        return 'active';
    return '';
}

function containsActiveRoute($route)
{
    if(strpos(Route::currentRouteName(), $route) !== false)
        return 'active';

    return '';
}

function generateBreadcrumbs($route)
{
    $route_elements = explode('.', $route);

    $breadcrumbs = [];
    $routechain = '';
    foreach($route_elements as $value)
    {
        if($value == 'index')
            break;

        $breadcrumbs[] = [
            'name' => trans('admin.bc_' . $value),
            'url' => (end($route_elements) === $value ? null : route($routechain . $value . '.index')),
            'first' => false,
            'last' => false,
        ];

        $routechain .= $value . '.';
    }

    $breadcrumbs[0]['first'] = true;
    $breadcrumbs[count($breadcrumbs) - 1]['last'] = true;

    return $breadcrumbs;
}

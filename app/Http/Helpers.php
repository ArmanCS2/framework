<?php



function sidebarActive($route,$contain=true)
{
    $route = str_replace(currentDomain(), "", $route);
    $route = trim($route, '/ ');

    $currentUrl = str_replace(currentDomain(), "", currentUrl());
    $currentUrl = trim($currentUrl, '/ ');
    if ($contain) {
        if (strpos($currentUrl, $route) === 0) {
            return 'active';
        }
        return '';
    }
    if ($route == $currentUrl) {
        return 'active';
    }

    return '';

}
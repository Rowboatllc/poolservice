<?php
function item_link($routename, $label, $attrs, $permissions) {
    $active = in_array($routename, $permissions);
    return $active ? Html::link(route($routename), $label, $attrs) : '';
}

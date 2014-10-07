<?php

add_filter('shoestrap_section_class_main','set_classes_main',10,1);

function set_classes_main() {
    echo 'no-padding ';
}

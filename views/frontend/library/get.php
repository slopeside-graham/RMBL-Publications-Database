<?php

use PUBS\PUBS_Base;
use PUBS\PUB;

function library_get()
{
    pubs_enqueue_frontend_get_library();
    $filepath = plugin_dir_path(__FILE__) . 'get.html';
    $html = file_get_contents($filepath);
    $output = '';

    $output = $html;
    return $output;
}

/*

Library Formatting

All Items: 
Reference Type Name (IF Student = T) { - STUDENT}

Article Formatting:
Authors Year. Title. Journal Name Voulume:Page

Book Formatting:
Authors Year. Title. Publication Name Publication City State Publication Pages " pages".

Chapter Formatting:
Authors Year. Chapter Title "in" Title. Publication Name Publication City State "pp "Text Pages

Other Formatting: 
Authors Year. Title. Rest Of Reference

Paper Formatiing: 
Authors Year. Title. "Student Paper". Rest of Reference

Thesis Formatting:
Authors Year. Title Degree. Institution


All Items Links: 
Links: pdf url, abstract url





*/

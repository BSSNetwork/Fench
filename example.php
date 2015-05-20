<?php
require 'src/view.php';

$view=new view();

$view->setPath('views/'); //Set Template File Storage Directory, Must end with "/"

//The First Method For Setting The Output parameters
$view->setAttr("title", "Variable example");
//The Second Method For Setting The Output Parameters
$view->array = array(
            '1' => "First array item",
            '2' => "Second array item",
            'n' => "N-th array item",
);
$view->j = 5;
//Enter The Page Header, Content, Footer
$view->display("header.php")->display('index.php')->display('footer.php')->render();

// Direct Output Single File

$view=new ('index.php');
$view->render();
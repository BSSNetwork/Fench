#Fench

Quick and Easy PHP Template Engine,
this code is only 147 lines .


<?php
require 'view.php';
 
$view=new view();

$view->setPath('theme/views/');//Set Template File Storage Directory, Must end with "/"
 
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

```
// Direct Output Single File
```
$view=new ('index.php');
$view->render();
```
#Template File
if - else
```
{if $array}
    ...
{elseif $array[0]!=null}
    ...
{else}
    ...
{/if}
```
Foreach loop
```
{foreach $array as $key => $value}
    {$key} => {$value}<br />
{/foreach}
```
while loop
```
{$i = 1}
{while $i < $j}
  Current no. {$i}<br />
  {$i++}
{/while}
```
for loop
```
{for ($i=0;$i<count($array);$i++)}
    {$array[$i]}
{/for}
```
Assignment Calculation
```
{$i = 1} // There must be a space before and after the equals sign =
{$i++}
{$i--}
```
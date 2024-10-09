# PHPe-GP_module (Thai e-Government Procurement)
## php ≥ 7.x
### example
```
<?php
echo e_GP(['egpid']);
?>
```
or
```
<?php
require_once 'e_GP.php';
echo e_GP(['egpid']);
?>
```
### json to csv
```
<?php
require_once 'e_GP.php';
$arrayData = json_decode(e_GP(['egpid']), true);
if ($arrayData === null) {
    die('Invalid JSON data');
}

$csvFile = fopen('output.csv', 'w');

if ($csvFile === false) {
    die('Error opening the file');
}

fputcsv($csvFile, array_keys($arrayData[0]));

foreach ($arrayData as $row) {
    fputcsv($csvFile, $row);
}

fclose($csvFile);
?>
```

![image](https://github.com/user-attachments/assets/03d63d93-dbb7-47ea-8d42-cbc9ae190d15)


###### JavaScript
###### https://github.com/h4rdl0ckl3z/JSe-GP_module
###### Python
###### https://github.com/h4rdl0ckl3z/PYe-GP_module

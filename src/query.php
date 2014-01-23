<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

if(isset($_GET['param'])) {
    $db = new PDO('sqlite:strings.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->query("PRAGMA case_sensitive_like = ON");
    
    $q = $db->prepare("
        SELECT 
            strings.str, 
            strings.anim_id, 
            strings.type, 
            files.name AS filename,
            files.type AS filetype
        FROM 
            strings,files
        WHERE
            strings.file = files.id AND 
            strings.str LIKE ?");
    $s = "%".$_GET['param']."%";
    $q->bindValue(1, $s, PDO::PARAM_STR);
    $q->execute();
    $result = $q->fetchAll();

    print(json_encode($result));
    die();
}
print(json_encode(array()));
?>
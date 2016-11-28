<?php 
function implodeUrl($paramArray = []) {
    if(!empty($paramArray)) {
        $paramStr = "";
        foreach($paramArray as $param => $value) {
            $paramStr .= $param."=".$value;
        }

        return $paramStr;
    }

    return "";
}
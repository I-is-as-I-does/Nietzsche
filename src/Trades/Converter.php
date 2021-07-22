<?php
/* This file is part of Nietzsche | SSITU | (c) 2021 I-is-as-I-does */
namespace SSITU\Nietzsche\Trades;

class Converter
{

    public static function objToArr($obj)
    {
        $variables = [];
        $reflect = new \ReflectionClass($obj);
        $props = $reflect->getProperties(\ReflectionProperty::IS_PUBLIC);
        $const = $reflect->getConstants(\ReflectionProperty::IS_PUBLIC);
        $methods = $reflect->getMethods(\ReflectionProperty::IS_PUBLIC);

        foreach ([$methods, $const, $props] as $k => $itms) {
            if (!empty($itms)) {
                foreach ($itms as $sk => $itm) {
                    if ($k === 1) {
                        $variables[$sk] = $itm;
                    } else {
                        $name = $itm->getName();
                        if ($k === 0) {
                            $value = $obj->$name();
                        } else {
                            $value = $obj->$name;
                        }
                        $variables[$name] = $value;
                    }
                }
            }
        }
        return $variables;
    }

}

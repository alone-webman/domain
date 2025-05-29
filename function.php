<?php

use AloneWebMan\Domain\Mid;

/**
 * @param array|string $domain 域名列表 支持*.域名
 * @param Closure|null $error  不支持域名时显示内容
 */
function alone_mid_domain(array|string $domain = "", Closure|null $error = null): Mid {
    return new Mid($domain, $error);
}

if (!function_exists('alone_domain')) {
    /**
     * 判断域名
     * @param string       $domain 当前访问的域名
     * @param array|string $list   *=全部开放 支持*.域名
     * @param bool         $type   是否允许使用*
     * @param int          $i
     * @return bool true=允许访问，false=禁止访问
     */
    function alone_domain(string $domain, array|string $list, bool $type = true, int $i = 0): bool {
        $rest = is_array($list) ? $list : explode(',', $list);
        $arr = explode("://", strtolower($domain));
        $array = explode("/", end($arr));
        $host = $array[key($array)];
        $hostArr = explode('.', $host);
        foreach ($rest as $v) {
            $val = strtolower($v);
            if ($host == $val) {
                $i++;
                break;
            }
            if ($type === true) {
                if ($v == '*') {
                    $i++;
                    break;
                } elseif (str_starts_with($val, '*.')) {
                    if (join('.', array_slice($hostArr, -count(explode(".", substr($v, 2))))) == substr($v, 2)) {
                        $i++;
                        break;
                    }
                }
            }
        }
        return $i > 0;
    }
}
# 中间件-域名绑定

* 仅限在webman中使用

### 安装仓库

```text
composer require alone-webman/domain
```

### 中间件方法

* 可以任何`config/middleware.php`中使用

```php
/**
 * @param array|string $domain 域名列表 支持*.域名
 * @param Closure|null $error  不支持域名时显示内容
 */
return [
    '@' => [alone_mid_domain(array|string $domain = "", Closure|null $error = null)]
];
```

### 判断域名方法

* 不使用中间件时可以使用此方法

```php

/**
 * 判断域名
 * @param string       $domain 当前访问的域名
 * @param array|string $list   *=全部开放 支持*.域名
 * @param bool         $type   是否允许使用*
 * @return bool true=允许访问，false=禁止访问
*/
alone_domain(string $domain, array|string $list, bool $type = true): bool
```
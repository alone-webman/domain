<?php

namespace AloneWebMan\Domain;

use Closure;

class Mid {
    protected array|string $domainList  = [];
    protected Closure|null $domainError = null;

    /**
     * @param array|string $domain 域名列表 支持*.域名
     * @param Closure|null $error  不支持域名时显示内容
     */
    public function __construct(array|string $domain = "", Closure|null $error = null) {
        $this->domainList = $domain;
        $this->domainError = (!empty($error) ? $error : function() {
            if (request()->expectsJson()) {
                return json(['code' => 404, 'msg' => "404 not found"])->withStatus(404);
            }
            return response("<html><head><title>404 Not Found</title></head><body><center><h1>404 Not Found</h1></center></body></html>", 404);
        });
    }

    public function process($request, $next) {
        if (!$this->domainList || alone_domain($request->host(true), $this->domainList)) {
            return $next($request);
        }
        return ($this->domainError)();
    }
}
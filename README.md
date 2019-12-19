# WdnmdApi

理论上说这是一个专注服务器端API的PHP框架，但目前(2019-11-25)它还很垃圾，只有简单的路由啥的。

# 目录结构

```
|- app                    应用目录
|   |- Admin              应用1
|   |- Home               应用2
|- public                 入口、静态文件目录
|- WdnmdApi               框架主目录
|   |- Base               根类文件
|   |- Config             配置文件
|   |   |- action.php     业务处理配置
|   |   |- database.php   数据库配置
|   |- Core               核心文件
|   |   |- Action.php     业务处理
|   |   |- Cache.php      缓存
|   |   |- Core.php       核心
|   |   |- DB.php         数据库
|   |   |- File.php       文件处理
|   |   |- Log.php        日志处理
|   |   |- Request.php    用户请求
|   |   |- Response.php   响应处理
|   |   |- Router.php    路由
|   |- Function.php       公用函数
|   |- WdnmdApi.php       框架入口
```

# TODO List

- [x] 路由支持URLRewrite
- [ ] 注入式路由
- [ ] 防CSRF攻击(现学现卖)
- [ ] 防SQL注入(现学现卖)
- [ ] 多语言(现学现卖)
- [ ] 完善核心文件
magicsso
========

magic project of sso

## 简单构架描述

参考 CAS 协议实现
http://www.blogjava.net/security/archive/2006/10/02/sso_in_action.html

magicsso 实现一个 user 的注册，认证，tgt分发的服务系统，开启其他子网站权限。

### 注册
通用注册步骤，需要email激活功能。

### 认证
配合子网站的 redirect action 做不同的认证，认证成功后分发 tgt 给用户，同时转向源请求网站。源请求网站得到用户拿到的 tgt ，使用该 tgt 去 magicsso 获取用户信息，以决定用户之前的认证是否有效(这里需要有时间限制)。

### tgt 分发服务系统
见如上认证描述，tgt (Ticket Granting Ticket) 为一个 auth active token，任何一个子网站 redirect 用户去 magicsso 获取权限的时候，magicsso 都会问用户要这个 token，已确定是否需要再次让用户输入密码认证，如果有效用户则免除输入密码认证，完成单点登录的功能。

### 开启其他子网站权限
为避免对每个子网站做更大修改，子网站的用户是独立的，只是子网站的用户生成是由 magicsso 控制的。
用户必须使用 magicsso 同步帐号，即开启权限。


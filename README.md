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

## 配置/使用方法

与各个模块的整合请参照
- [Magic Wordpress](https://github.com/zy-sunshine/magicwordpress)
- [Magic Discuz](https://github.com/zy-sunshine/magicdiscuz)

### 配置文件
src/MagicSSO/Resources/config 下面是配置文件。
其中需要用户自己创建配置的是 parameters.yml 文件
文件内容如下:
``` yaml
parameters:
    database_driver:   pdo_mysql
    database_host:     localhost
    database_port:     ~
    database_name:     symfony
    database_user:     <username>
    database_password: <password>

    mailer_transport:  gmail
    # mailer_host:       localhost
    mailer_user:       <gmail username>
    mailer_password:   <gmail password>

    locale:            en  # 如果使用中文这个需要改成 zh_CN
    secret:            ThisTokenIsNotSoSecretChangeIt
```
database可以选择 sqlite，具体请参考 Symfony document
这里默认配置使用 gmail 做邮件服务器，如果想要使用自己的 mail 服务器也参考 Symfony document
如果想要关闭 email 激活功能，可以修改 config.yaml > `registration.confirmation.enabled`: `false`

### 制定邮件信息
如果开启 email 发送功能，则该网站每注册一个用户，邮件服务器都会给相应发送一封邮件来验证用户的身份。
邮件发送者和内容是可以制定的，关于发送者可以修改 config.yaml `registration`|`resetting` 下面的 `sender_name` 字段。
邮件内容需要修改下面两个文件(包括邮件标题和内容):
```
src/MagicSSO/Resources/views/User/registration.email.twig
src/MagicSSO/Resources/views/User/resetting.email.twig
```
**Note:**

> 模板里面分两块 `{% block body_text %}`，`{% block body_html %}`，根据系统的配置会使用不同的块来渲染，目前使用 html 渲染方式。
> `{% block subject %}` 是邮件标题


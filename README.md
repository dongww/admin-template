#管理后台界面模板框架

基于 [bootstrap](https://github.com/twbs/bootstrap) 和 
[AdminLTE](https://github.com/almasaeed2010/AdminLTE) 开发的后台界面模板，集成众多组件，便于开发人员快速创建后台界面。

##目录结构

    |--README.md              项目说明
    |--run.bat                开发调试环境服务器启动文件，双击启动。http://localhost:8012
    |--builder                包含开发工具和静态文件生成工具
    |--dist                   包含最终生成的供演示用的目标静态文件
    |    |--index.html        索引页
    |    |--css               样式表目录
    |    |--image             图片目录
    |    |--js                Javascript 目录
    |    |--pages             包含所有演示页面
    |        |--ajax          通过 AJAX 技术动态调取内容
    |        |--content       各种以文本或图文展示性内容为主的演示页面
    |        |--example       各种特殊场景、综合类及较复杂的演示页面
    |        |--form          各种表单相关的演示页面
    |        |--home          各种管理后台首页的演示页面
    |        |--list          各种列表形式为主的演示页面
    |--docs                   说明文档目录
         |--specification.md       及至极客后台通用设计语言规范

##构建工具说明
dist 目录中的 HTML 文件是由模板编译生成，供界面制作人员参考使用。
builder 目录包含了生成静态页面的脚本工具，使用 PHP 编写，包括：

* 模板引擎，可以在页面中包含可复用的局部内容
* 内置服务器启动脚本，可以模拟服务器环境进行模板文件调试
* 命令行工具 console 。该工具可以将制作的模板编译生成纯静态 HTML 文件。使用方法： `php console f:g`
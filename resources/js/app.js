// resources/js/app.js

// 引入 jQuery
import $ from 'jquery';
// 将 jQuery 注册到全局作用域，方便在其他脚本中使用 window.$ 或 window.jQuery 调用
window.$ = window.jQuery = $;

// 引入自定义的 bootstrap 初始化文件（通常包含配置或依赖的初始化）
import './bootstrap';

// 引入 Bootstrap 的 CSS 样式
import 'bootstrap/dist/css/bootstrap.min.css';

// 引入 Bootstrap 的 JavaScript 模块（Popper、Modal 等组件功能）
import * as bootstrap from 'bootstrap';
// 将 bootstrap 模块注册为全局变量，方便在页面脚本中调用
window.bootstrap = bootstrap;

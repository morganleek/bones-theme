/*!
 * 
 * bonesTheme
 * 
 * @author 
 * @version 0.1.0
 * @link UNLICENSED
 * @license UNLICENSED
 * 
 * Copyright (c) 2024 
 * 
 * This software is released under the UNLICENSED License
 * https://opensource.org/licenses/UNLICENSED
 * 
 * Compiled with the help of https://wpack.io
 * A zero setup Webpack Bundler Script for WordPress
 */
(window.wpackiobonesThemeappJsonp=window.wpackiobonesThemeappJsonp||[]).push([[0],{3:function(e,t,o){o(4),e.exports=o(5)},5:function(e,t,o){"use strict";o.r(t);var n=o(2),c=o(1);n.a.registerPlugin(c.a),document.addEventListener("DOMContentLoaded",(function(){if(document.querySelectorAll('img[loading="lazy"]').forEach((function(e){!0===e.complete&&e.classList.add("has-loaded"),e.addEventListener("load",(function(e){e.target.classList.add("has-loaded")}))})),document.querySelector("body.home")){var e=document.querySelector("header.wp-block-template-part");document.querySelector(".wp-block-post-content > *:nth-child(1)").offsetHeight,c.a.create({trigger:document.querySelector(".wp-block-post-content > *:nth-child(1)"),start:"60% top",end:"10000px",onToggle:function(t){return e.classList.toggle("active",t.isActive)}})}document.querySelectorAll(".copyright").forEach((function(e){e.innerHTML=e.innerHTML.replace("{YEAR}",(new Date).getUTCFullYear())}))}))}},[[3,1,2]]]);
//# sourceMappingURL=main-4d53f892.js.map
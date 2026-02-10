/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
   $(document).on("change", "input[type=text]",function(){
       var text = $(this).val();
       var value = text.replace(/(\'|&#0*39;|&quot;|\")/, '&apos;');
       $(this).val(value);
   });
   
});

//function replace_special_char(){
//    console.log("ccccccccccccccccccc")
//     $("input[type=text]").each(function(){
//       var text = $(this).val();
//       var value = text.replace(/\&apos;/g,"'");
//       $(this).val(value);
//   })
//}
//
//$(window).load(function() {
//    replace_special_char();
//})